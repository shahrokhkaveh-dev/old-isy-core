<?php

namespace App\Repositories;

use App\Models\Visit;
use App\Repositories\Product\ProductRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class VisitRepository
{
    public function getVisitsForLastDays(int $days = 7): Collection
    {
        return Visit::selectRaw('DATE(created_at) as date, count(*) as count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    public function visitsLastDaysCount(int $subDays = 7): int
    {
        return Visit::where('created_at', '>=', now()->subDays($subDays))->count();
    }

    public function visitsTodayCount(): int
    {
        return Visit::today()->count();
    }

    public function totalUniqueVisitors(): int
    {
        return Visit::distinct('ip_address')->count('ip_address');
    }

    public function getTopPages(int $limit = 5): Collection
    {
        return Visit::select(['url', DB::raw('count(*) as count')])
            ->groupBy('url')
            ->orderByDesc('count')
            ->limit($limit)
            ->get();
    }
}
