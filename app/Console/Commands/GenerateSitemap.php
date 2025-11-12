<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate {type : The type of sitemap to generate (main or freezone)}';
    protected $description = 'Generate a sitemap index and multiple sitemap files for a specific site type (main or freezone)';

    private $config;
    private $locales;
    private $sitemapFiles = []; // To store the names of generated sitemap files

    public function handle()
    {
        $type = $this->argument('type');
        if (!in_array($type, ['main', 'freezone'])) {
            $this->error('Invalid type. Please use "main" or "freezone".');
            return Command::FAILURE;
        }

        $this->info("Starting sitemap generation for type: {$type}...");
        $this->config = config("sitemap.sites.{$type}");
        $this->locales = config('sitemap.locales');

        // Ensure the sitemaps directory exists
        $filesDir = public_path($this->config['files_path']);
        if (!is_dir($filesDir)) {
            mkdir($filesDir, 0755, true);
        }

        // Generate individual sitemap files
        $this->generateStaticSitemap();
        $this->generateBrandsSitemap(); // This method now handles splitting
        $this->generateCategoriesSitemap();
        $this->generateProductsSitemaps();

        // Generate the main index file
        $this->generateSitemapIndex();

        $this->info("Sitemap generation for '{$type}' completed successfully.");
        $this->info("Main index file: " . public_path($this->config['index_path']));
        $this->info("Generated files: " . implode(', ', $this->sitemapFiles));

        return Command::SUCCESS;
    }

    private function createXmlWriter(string $filename)
    {
        $filePath = public_path($this->config['files_path'] . $filename);
        $xml = new \XMLWriter();
        $xml->openURI($filePath);
        $xml->startDocument('1.0', 'UTF-8');
        $xml->setIndent(true);
        $xml->setIndentString('  ');
        $xml->startElement('urlset');
        $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        return $xml;
    }

    private function finishXmlWriter(\XMLWriter $xml)
    {
        $xml->endElement(); // </urlset>
        $xml->endDocument();
        $xml->flush();
    }

    private function addUrlToWriter(\XMLWriter $xml, string $loc, ?string $lastmod = null, string $changefreq = 'weekly', float $priority = 0.8)
    {
        $xml->startElement('url');
        $xml->writeElement('loc', $loc);
        if ($lastmod) {
            $xml->writeElement('lastmod', date('Y-m-d\TH:i:s\Z', strtotime($lastmod)));
        }
        $xml->writeElement('changefreq', $changefreq);
        $xml->writeElement('priority', number_format($priority, 1));
        $xml->endElement(); // </url>
    }

    private function generateStaticSitemap()
    {
        $this->info('Generating static sitemap...');
        $xml = $this->createXmlWriter('sitemap-static.xml');
        $baseUrl = $this->config['base_url'];

        foreach ($this->locales as $locale) {
            $this->addUrlToWriter($xml, "{$baseUrl}/{$locale}", null, 'daily', 1.0);
            $this->addUrlToWriter($xml, "{$baseUrl}/{$locale}/Signin", null, 'monthly', 0.5);
            $this->addUrlToWriter($xml, "{$baseUrl}/{$locale}/About", null, 'monthly', 0.5);
            $this->addUrlToWriter($xml, "{$baseUrl}/{$locale}/Namad", null, 'monthly', 0.5);
            $this->addUrlToWriter($xml, "{$baseUrl}/{$locale}/Brands", null, 'weekly', 0.8);
            $this->addUrlToWriter($xml, "{$baseUrl}/{$locale}/products", null, 'weekly', 0.8);
        }
        $this->finishXmlWriter($xml);
        $this->sitemapFiles[] = 'sitemap-static.xml';
    }

    /**
     * Generate sitemaps for brands, splitting into multiple files if necessary.
     */
    private function generateBrandsSitemap()
    {
        $this->info('Generating brands sitemap...');
        $baseUrl = $this->config['base_url'];
        $type = $this->argument('type');
        $maxUrls = config('sitemap.max_urls');
        $sitemapIndex = 1;
        $urlCount = 0;

        // Create the first brands sitemap file
        $xml = $this->createXmlWriter("sitemap-brands-{$sitemapIndex}.xml");
        $this->sitemapFiles[] = "sitemap-brands-{$sitemapIndex}.xml";

        $brandsQuery = Brand::query()->select('slug', 'updated_at');
        if ($type === 'freezone') {
            $brandsQuery->whereNotNull('freezone_id');
        }

        // Pass variables by reference to the chunk closure to maintain their state
        $brandsQuery->chunk(200, function ($brands) use (&$xml, &$sitemapIndex, &$urlCount, $maxUrls, $baseUrl) {
            foreach ($brands as $brand) {
                foreach ($this->locales as $locale) {
                    // If the current file reaches the max URL limit, create a new one
                    if ($urlCount >= $maxUrls) {
                        $this->finishXmlWriter($xml); // Close the current file
                        $sitemapIndex++;
                        $xml = $this->createXmlWriter("sitemap-brands-{$sitemapIndex}.xml"); // Open a new file
                        $this->sitemapFiles[] = "sitemap-brands-{$sitemapIndex}.xml";
                        $urlCount = 0; // Reset URL counter for the new file
                    }
                    $this->addUrlToWriter($xml, "{$baseUrl}/{$locale}/Brands/{$brand->slug}", $brand->updated_at, 'weekly', 0.9);
                    $urlCount++;
                }
            }
        });

        // Don't forget to close the last brands sitemap file
        $this->finishXmlWriter($xml);
    }

    private function generateCategoriesSitemap()
    {
        $this->info('Generating categories sitemap...');
        $xml = $this->createXmlWriter('sitemap-categories.xml');
        $baseUrl = $this->config['base_url'];
        $type = $this->argument('type');

        // Brand categories
        $brandCategoriesQuery = Category::query()->select('id', 'updated_at');
        if ($type === 'freezone') {
            $brandCategoriesQuery->whereHas('brands', fn($q) => $q->whereNotNull('freezone_id'));
        } else {
            $brandCategoriesQuery->whereHas('brands');
        }
        $brandCategories = $brandCategoriesQuery->get();
        foreach ($brandCategories as $category) {
            foreach ($this->locales as $locale) {
                $this->addUrlToWriter($xml, "{$baseUrl}/{$locale}/Brands?category={$category->id}", $category->updated_at, 'weekly', 0.7);
            }
        }

        // Product categories
        $productCategoriesQuery = Category::query()->select('id', 'updated_at')->whereHas('products');
        if ($type === 'freezone') {
            $productCategoriesQuery->whereHas('products', fn($q) => $q->whereHas('brand', fn($sq) => $sq->whereNotNull('freezone_id')));
        }
        $productCategories = $productCategoriesQuery->get();
        foreach ($productCategories as $category) {
            foreach ($this->locales as $locale) {
                $this->addUrlToWriter($xml, "{$baseUrl}/{$locale}/products?category={$category->id}", $category->updated_at, 'weekly', 0.7);
            }
        }

        $this->finishXmlWriter($xml);
        $this->sitemapFiles[] = 'sitemap-categories.xml';
    }

    private function generateProductsSitemaps()
    {
        $this->info('Generating product sitemaps...');
        $baseUrl = $this->config['base_url'];
        $type = $this->argument('type');
        $maxUrls = config('sitemap.max_urls');
        $sitemapIndex = 1;
        $urlCount = 0;

        $xml = $this->createXmlWriter("sitemap-products-{$sitemapIndex}.xml");
        $this->sitemapFiles[] = "sitemap-products-{$sitemapIndex}.xml";

        $productsQuery = Product::select('slug', 'updated_at');
        if ($type === 'freezone') {
            $productsQuery->whereHas('brand', fn($q) => $q->whereNotNull('freezone_id'));
        }

        $productsQuery->chunk(1000, function ($products) use (&$xml, &$sitemapIndex, &$urlCount, $maxUrls, $baseUrl) {
            foreach ($products as $product) {
                foreach ($this->locales as $locale) {
                    if ($urlCount >= $maxUrls) {
                        $this->finishXmlWriter($xml);
                        $sitemapIndex++;
                        $xml = $this->createXmlWriter("sitemap-products-{$sitemapIndex}.xml");
                        $this->sitemapFiles[] = "sitemap-products-{$sitemapIndex}.xml";
                        $urlCount = 0;
                    }
                    $this->addUrlToWriter($xml, "{$baseUrl}/{$locale}/products/{$product->slug}", $product->updated_at, 'weekly', 0.9);
                    $urlCount++;
                }
            }
        });

        $this->finishXmlWriter($xml);
    }

    private function generateSitemapIndex()
    {
        $this->info('Generating main sitemap index file...');
        $indexPath = public_path($this->config['index_path']);
        $baseUrl = $this->config['base_url'];

        $index = new \XMLWriter();
        $index->openURI($indexPath);
        $index->startDocument('1.0', 'UTF-8');
        $index->setIndent(true);
        $index->setIndentString('  ');
        $index->startElement('sitemapindex');
        $index->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($this->sitemapFiles as $file) {
            $index->startElement('sitemap');
            $index->writeElement('loc', $baseUrl . '/' . $this->config['files_path'] . $file);
            $index->writeElement('lastmod', date('Y-m-d\TH:i:s\Z'));
            $index->endElement();
        }

        $index->endElement(); // </sitemapindex>
        $index->endDocument();
        $index->flush();
    }
}
