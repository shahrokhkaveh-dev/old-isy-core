
import HomeNews from '../module/HomeNews'
import HomeProduct from "../module/HomeProduct";
import HomeCategoryProducts from "../module/HomeCategoryProducts";
import CategoryNav from "../module/CategoryNav";
import CategoryMainHome from "../module/CategoryMainHome";
import ProductsSideHome from "../module/ProductsSideHome";
import HomeOption from "../module/HomeOption";
import BestProduct from '../module/BestProducts'
import { useEffect, useState } from 'react';
import { LazyLoadImage } from 'react-lazy-load-image-component';



export default function HomePage({ data }) {

    const [index, setIndex] = useState(0);
    const [direction, setDirection] = useState(1);


    useEffect(() => {
        const interval = setInterval(() => {
            setIndex((prevIndex) => {
                if (prevIndex === data.section1.banners.length - 1) {
                    setDirection(-1); // وقتی به انتها رسیدیم، کم کردن را شروع کن
                    return prevIndex - 1;
                } else if (prevIndex === 0) {
                    setDirection(1); // وقتی به ابتدا رسیدیم، زیاد کردن را شروع کن
                    return prevIndex + 1;
                }
                return prevIndex + direction;
            });
        }, 5000);


        return () => clearInterval(interval);
    }, [direction, data.section1.banners.length]);


    return (
        <div className=" p-8 pb-0 relative  hidden md:block"  >
            <div className="flex flex-row w-full relative py-5 bg-white">
                <CategoryMainHome category={data.section1.categories} />
                <div className="w-full flex flex-col">
                    <div className='w-full h-full overflow-hidden'>
                        <div style={{ transform: `translateX(${index * 100}%)` }} className={`transition-all duration-300 ease-in-out w-full h-full flex flex-row flex-nowrap `}>
                            {data.section1.banners.map((i, index) => (

                                <div className='min-w-full w-full'>
                                    <LazyLoadImage key={index} src={i} className='min-w-full w-full h-full ' alt="" />
                                </div>

                            ))}
                        </div>
                    </div>
                    <HomeOption />
                </div>
                <ProductsSideHome products={data.section1.products} />
            </div>

            <BestProduct products={data.section2.products} />

            <HomeCategoryProducts data={data.section3.products} />
            <div className="bg-[url('https://sanatyariran.com/banner/call.png')] min-h-72 bg-no-repeat bg-cover w-full flex flex-row justify-between px-16 py-7">
                <div >
                    <h3 className="text-xl font-semibold mb-12">منابع یابی آسان</h3>
                    <p className="text-wrap w-2/3 text-stone-500">
                        راهی آسان برای ارسال درخواست های منبع خود و دریافت قیمت.

                        یک درخواست، چند نقل قول


                        تطبیق تامین کنندگان تایید شده

                        مقایسه مظنه و درخواست نمونه
                    </p>
                </div>
                <div className="lg:min-w-[580px] md:min-w-[371px]  bg-white p-4 flex flex-col gap-y-4 ">
                    <h3 className="lg:text-xl md:text-lg font-semibold">میخواهید نقل و قول دریافت کنید ؟</h3>
                    <input placeholder="نام محصول و کلمات کلیدی" type="text" className="min-h-10 px-2 w-full border-[1px] border-zinc-300" />
                    <textarea placeholder="توضیحات محصول" name="" className="border-[1px] px-2 py-3 border-zinc-300 w-full overflow-auto min-h-20 outline-none" id=""></textarea>
                    <div className="grid grid-cols-2 w-fit gap-x-6">
                        <input placeholder="مقدار خرید" className="border-[1px] border-zinc-300 py-3 px-2 h-full" type="text" />
                        <input className="border-[1px] border-zinc-300 py-3 px-2 h-full" type="text" placeholder="قطعه های" name="" id="" />
                    </div>
                    <button className="text-white bg-blue-600 px-8 py-2 rounded-md font-light w-fit lg:text-base md:text-sm">متن درخواست خود را ارسال کنید</button>
                </div>
            </div>

            <section>
            </section>
            <HomeNews news={data.section4.blogs} />

            <CategoryNav categories={data.section5.categories} />

        </div>
    );
}
