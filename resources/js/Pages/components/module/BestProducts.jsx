import ProductHomeCard from "./ProductHomeCard";

export default function BestProducts({ products }) {

    return (
        <div className="bg-white px-10 mt-5">
            <div className="pt-8">
                <h3 className="text-lg font-bold">محصولات پرطرف دار</h3>
            </div>
            <div className="grid lg:grid-cols-6 md:grid-cols-5 gap-y-8  gap-x-9 pt-12 pb-7">
                {products.map((i) => (
                    <ProductHomeCard item={i} />
                ))}
            </div>
        </div>
    );
}