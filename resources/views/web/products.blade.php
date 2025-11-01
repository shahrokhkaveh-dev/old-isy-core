@extends('web.layout.layout')
@section('title')
    <title>محصولات و خدمات</title>
@endsection
@section('content')
<main class="companies">
    <div class="container">
        <div class="searchPage">
            <aside>
                <div class="aside-filters">
                    <form action="#" method="get" class="aside-filters-form">
                        <div class="aside-filters-title">
                            <span>فیلترها</span>
                            <button type="reset">حذف فیلترها</button>
                        </div>
                        <div class="aside-filter-search-input">
                            <label for="searchInput">
                                <input type="text" class="searchAsideInput" name="search" id="searchInput"
                                    @if (isset($_GET['search'])) value="{{ $_GET['search'] }}" @endif
                                    placeholder="نام محصول یا خدمت">
                            </label>
                        </div>
                        <label for="province_id">
                            <select class="aside-filter-select" name="province_id" id="province_id">
                                <option value="">استان</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}"
                                        @if (isset($_GET['province_id']) && $_GET['province_id'] == $province->id) selected @endif>
                                        {{ $province->name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label for="city_id">
                            <select class="aside-filter-select" name="city_id" id="city_id">
                                <option value="">شهر</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}"
                                        @if (isset($_GET['city_id']) && $_GET['city_id'] == $city->id) selected @endif>
                                        {{ $city->name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label for="ipark_id">
                            <select class="aside-filter-select" name="ipark_id" id="ipark_id">
                                <option value="">شهرک صنعتی</option>
                                @foreach ($iparks as $ipark)
                                    <option value="{{ $ipark->id }}" data-province="{{ $ipark->province_id }}"
                                        @if (isset($_GET['iparks']) && $_GET['iparks'] == $ipark->id) selected @endif>
                                        {{ $ipark->name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label for="categorySelect">
                            <select class="aside-filter-select" name="category_id" id="categorySelect">
                                <option value="">دسته بندی</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        @if (isset($_GET['category_id']) && $_GET['category_id'] == $category->id) selected @endif>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <div class="checkbox-wrapper">
                            <label for="justExportableCheckbox">نمایش محصولات صادراتی</label>
                            <input type="checkbox" class="isy-checkbox" name="justExportable" @if (isset($_GET['justExportable']) && $_GET['justExportable'] == 'on') checked @endif id="justExportableCheckbox" />
                        </div>
                        <div style="text-align: left;"><button type="submit">اعمال فیلتر</button></div>
                    </form>
                </div>
            </aside>
            <article>
                <section class="container main-section home-new-brands">
                    <h3 class="h3">محصولات صنعت یار</h3>
                    <div class="products-search-wrapper">
                        @foreach ($products as $p)
                        <div class="product-card">
                            <div class="product-card-image">
                                <a href="{{ route('user.product.show', $p->slug) }}">
                                    <img src="{{$p->image ? asset($p->image) : asset('image/productISYBox.png')}}" alt="">
                                </a>
                                @if ($p->isExportable)
                                <span class="product-card-ribbon">صادراتی</span>
                                @endif
                            </div>
                            <p class="product-card-title"><a href="{{ route('user.product.show', $p->slug) }}">{{$p->name}}</a></p>
                            <div class="product-card-footer">
                                <div class="product-card-location">
                                    <svg width="8" height="11" viewBox="0 0 8 11" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M5.3904 9.35024C6.54527 7.87755 8 5.73796 8 4.30435C8 1.92712 6.20914 0 4 0C1.79086 0 0 1.92712 0 4.30435C0 5.73796 1.45473 7.87755 2.6096 9.35024C3.21212 10.1186 3.51338 10.5027 4 10.5027C4.48662 10.5027 4.78788 10.1186 5.3904 9.35024ZM4 6C3.17157 6 2.5 5.32843 2.5 4.5C2.5 3.67157 3.17157 3 4 3C4.82843 3 5.5 3.67157 5.5 4.5C5.5 5.32843 4.82843 6 4 6Z"
                                              fill="#71787F"/>
                                    </svg>
                                    {{ $p->city ? $p->city->name : '' }}
                                </div>
                                <div class="product-card-location">
                                    <svg width="8" height="11" viewBox="0 0 8 11" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M5.3904 9.35024C6.54527 7.87755 8 5.73796 8 4.30435C8 1.92712 6.20914 0 4 0C1.79086 0 0 1.92712 0 4.30435C0 5.73796 1.45473 7.87755 2.6096 9.35024C3.21212 10.1186 3.51338 10.5027 4 10.5027C4.48662 10.5027 4.78788 10.1186 5.3904 9.35024ZM4 6C3.17157 6 2.5 5.32843 2.5 4.5C2.5 3.67157 3.17157 3 4 3C4.82843 3 5.5 3.67157 5.5 4.5C5.5 5.32843 4.82843 6 4 6Z"
                                              fill="#71787F"/>
                                    </svg>
                                    <a href="">{{$p->brand->name}}</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                <div>
                    {{ $products->links('web.paginate') }}
                </div>
            </article>
        </div>
    </div>
</main>
@endsection
