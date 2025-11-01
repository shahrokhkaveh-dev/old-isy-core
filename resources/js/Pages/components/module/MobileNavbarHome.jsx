import { Link } from "@inertiajs/react";
import { useEffect, useState } from "react";
import { LazyLoadImage } from "react-lazy-load-image-component";

export default function MobileNavbarHome({ banner }) {
    const [index, setIndex] = useState(0);
    const [direction, setDirection] = useState(1);


    useEffect(() => {
        const interval = setInterval(() => {
            setIndex((prevIndex) => {
                if (prevIndex === banner.length - 1) {
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
    }, [direction, banner.length]);

    return (
        <section className="md:hidden ">
            <div className="pt-2 sm:pt-4 ">
                <div className="w-full min-w-full overflow-hidden ">
                    <div style={{ transform: `translateX(${index * 100}%)` }} className="transition-all duration-300 ease-in-out  flex flex-row flex-nowrap  h-auto w-full">
                        {banner.map((i) => (
                            <div className="min-w-full w-full h-auto">
                                <LazyLoadImage className="w-full min-w-full h-full" src={i} alt="" />
                            </div>
                        ))}
                    </div>
                </div>
                <div className="px-3 sm:px-5 py-2 sm:py-4">
                    <ul className="flex justify-between text-[8px] sm:text-sm">
                        <li className=""><Link href="/new/products?per_page=50">
                            <img className="mx-auto  sm:w-[35px] sm:h-[35px]" src="https://sanatyariran.com/images/download (4) (1).svg" alt="" />
                            همه دسته‌ها
                        </Link>
                        </li>
                        <li className=" "><a href="#">
                            <img className="mx-auto sm:w-[35px] sm:h-[35px]" src="https://sanatyariran.com/images/book-icon 4.svg" alt="" />
                            مجله صنعت یار
                        </a>
                        </li>
                        <li className=" "><a href="#">
                            <img className="mx-auto sm:w-[35px] sm:h-[35px]" src="https://sanatyariran.com/images/download (3) (1).svg" alt="" />
                            RFQ ارسال
                        </a></li>
                        <li className=" "><a href="#">
                            <img className="mx-auto sm:w-[35px] sm:h-[35px]" src="https://sanatyariran.com/images/download (1).svg" alt="" />
                            کانال ویدیویی
                        </a></li>
                        <li className=" "><a href="#">
                            <img className="mx-auto sm:w-[35px] sm:h-[35px]" src="https://sanatyariran.com/images/download.svg" alt="" />
                            دانلود اپلیکیشن
                        </a></li>
                    </ul>
                </div>
            </div>
        </section>
    );
}