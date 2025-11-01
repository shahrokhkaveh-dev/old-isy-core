import { IoSearch } from "react-icons/io5";
import { MdOutlineMenu } from "react-icons/md";
import { TbTargetArrow } from "react-icons/tb";
import { FaRegUser } from "react-icons/fa6";
import { LuMessagesSquare } from "react-icons/lu";
import { MdOutlineShoppingCart } from "react-icons/md";
import { TfiMenuAlt } from "react-icons/tfi";
import { IoIosArrowDown } from "react-icons/io";
import { FaRegUserCircle } from "react-icons/fa";
import { useSidebar } from "../../Context/SidebarContext"
import { Link, router, usePage } from '@inertiajs/react';
import { useState } from "react";

export default function Header() {

    const [Search, setSearch] = useState('')
    const [SearchType, setSearchType] = useState('products')

    const { auth, categories } = usePage().props;

    const { toggleSidebar } = useSidebar()

    const LinkSearchHandler = () => {
        console.log("link")
        if (!Search || !SearchType) return
        router.get(`/new/${SearchType}?search=${Search}`)
    }
    const SearchHndler = (e) => {
        if (e.key === "Enter") {
            LinkSearchHandler()
        }


    }




    return (

        <header className="border-b-[1px] bg-white border-gray-200">
            <div className="max-w-[1440px] mx-auto">
                <div className="flex p-5 flex-col ">
                    <div className="flex md:p-5 justify-between items-center">
                        <button onClick={toggleSidebar} className="block md:hidden text-xl">
                            <MdOutlineMenu />
                        </button>
                        <div className="">
                            <a className="" href="https://sanatyariran.com">
                                <img className=" md:w-60 w-36" src="https://sanatyariran.com/images/logo.png" alt="" />
                            </a>
                        </div>
                        <a href="https://sanatyariran.com/panel" className="md:hidden">
                            <FaRegUserCircle className="text-xl " />
                        </a>
                        <div className="w-full px-14 hidden md:block">
                            <div className="overflow-hidden border-blue-800 border-2 rounded-3xl">
                                <div className="flex">
                                    <select onChange={(e) => setSearchType(e.target.value)} name="" id="" className="outline-none w-24 px-1 cursor-pointer">
                                        <option className="cursor-pointer" value="products">محصولات</option>
                                        <option className="cursor-pointer" value="brands">شرکت ها</option>
                                    </select>
                                    <div className="mr-1 ml-3 border-l-2 border-solid border[#DADADA]"></div>
                                    <input onKeyDown={SearchHndler} value={Search} onChange={(e) => setSearch(e.target.value)} type="text" placeholder="لطفا نام محصول مورد نظر خود را وارد کنید ... " className="outline-0 w-full" />
                                    <button onClick={LinkSearchHandler} type="submit" className="p-2 cursor-pointer border-0 bg-blue-800 rounded-2xl rounded-r-none">
                                        <IoSearch className="text-2xl text-white" />
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div className="hidden md:flex gap-4 flex-row gap-x-8">
                            {/* <a className="group text-center flex flex-col items-center gap-y-2" href="#">
                                <TbTargetArrow className="text-2xl" />
                                <span className="text-sm text-nowrap hidden lg:block" href="#"> RFQ ارسال</span>

                                <p className=" group-hover:block hidden absolute top-20 z-50 bg-white rounded-md p-4 shadow-lg  ">آنچه را که نیاز دارید به ما بگویید و راه آسان برای دریافت قیمت را امتحان کنید</p>
                            </a> */}
                            <a className="group text-center flex flex-col items-center gap-y-2" href="https://sanatyariran.com/panel">
                                <FaRegUser className="text-2xl " />
                                <span className="text-sm text-nowrap hidden lg:block" href="#">ورود / ثبت نام </span>
                            </a>
                            {/* <a className="text-center flex flex-col items-center gap-y-2" href="#">
                                <LuMessagesSquare className="text-2xl" />
                                <span className="text-sm text-nowrap hidden lg:block" href="#">پیام ها</span>
                            </a>
                            <a className="text-center flex flex-col items-center gap-y-2" href="#">
                                <MdOutlineShoppingCart className="text-2xl" />
                                <span className="text-sm text-center text-nowrap hidden lg:block" href="#">سبد استعلام </span>
                            </a> */}
                        </div>
                    </div>
                    <div className=" flex-row-reverse justify-between hidden text-sm md:flex  border-t-[1px] pt-2">

                        <ul className="flex">
                            <li className="mx-5 group relative ">
                                <p className="flex flex-row items-center ">تامین کننده<IoIosArrowDown className="text-xs mx-1" /></p>
                                <ul className="absolute mt-1 font-light group-hover:flex hidden z-50 -left-10 bg-white  flex-col gap-y-3 min-w-48 shadow-md text-nowrap px-2 py-3  rounded-md">
                                    <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-600">به عضویت پرمیوم بپیوندید</li>
                                    <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-600">بازار خدمات تجاری خارجی</li>
                                    <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-600">تجارت خارجی خانه الکترونیکی</li>
                                    <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-600">نمایشگاه ابری هوشمند</li>
                                    <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-600">خدمات تراکنش</li>
                                    <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-600">ساخت ایستگاه تجارت داخلی ایران</li>
                                    <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-600">هوش مصنوعی</li>
                                </ul>
                            </li>
                            {/* <li className="group  relative flex items-center pl-5 cursor-pointer">
                                <span className="pl-1" href="#">خریداران</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                    <path fillRule="evenodd" clipRule="evenodd"
                                        d="M2.27903 3.5373C2.40107 3.40423 2.59893 3.40423 2.72097 3.5373L4.77903 5.78125C4.90107 5.91431 5.09893 5.91431 5.22097 5.78125L7.27903 3.5373C7.40107 3.40424 7.59893 3.40424 7.72097 3.5373C7.84301 3.67036 7.84301 3.8861 7.72097 4.01916L5.66291 6.26311C5.2968 6.6623 4.7032 6.6623 4.33709 6.26311L2.27903 4.01916C2.15699 3.88609 2.15699 3.67036 2.27903 3.5373Z"
                                        fill="black" />
                                </svg>
                                <div className="hidden group-hover:block z-50 absolute top-0 bottom-0 left-0    mt-5 bg-red-400">
                                    <div className="bg-white flex flex-row text-nowrap rounded-md p-3">
                                        <ul className="px-2 font-light ">
                                            <li>
                                                <ul className="flex flex-col gap-y-2">
                                                    <li className="text-lg font-semibold text-black">خدمات</li>
                                                    <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-500" >راهنمای کاربر جدید</li>
                                                    <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-500" >گزارش‌های تامین کنندگان حساب رسی شده</li>
                                                    <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-500" >با تامین کنندگان آشنا شوید </li>
                                                    <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-500" >خدمات بازرگانی امن</li>
                                                    <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-500" >مرکزخرید</li>
                                                    <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-500" >تماس با ما</li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <div className="flex flex-col gap-y-2 bg-white border-r-[1px] px-2 border-zinc-200">
                                            <ul className="flex flex-col gap-y-2 font-light">
                                                <li className="text-lg font-semibold text-black">فهرست محصولات </li>
                                                <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-500" >پیدا کردن تامین کنندگان</li>
                                                <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-500" >درخواست منبع پست</li>
                                            </ul>
                                            <ul className="flex flex-col gap-y-2 font-light">
                                                <li className="text-lg font-semibold text-black">لینک های سریع</li>
                                                <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-500" >موارد دلخواه من</li>
                                                <li className="cursor-pointer transition-all ease-in-out duration-200 hover:text-blue-500" >تاریخچه مرور</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li> */}
                            <div className="ml-5 border-l-2 border-solid border[#DADADA]"></div>
                            <li className="group  relative flex items-center pl-5 cursor-pointer">
                                {/* <span className="pl-1" href="#">راهنما</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                    <path fillRule="evenodd" clipRule="evenodd"
                                        d="M2.27903 3.5373C2.40107 3.40423 2.59893 3.40423 2.72097 3.5373L4.77903 5.78125C4.90107 5.91431 5.09893 5.91431 5.22097 5.78125L7.27903 3.5373C7.40107 3.40424 7.59893 3.40424 7.72097 3.5373C7.84301 3.67036 7.84301 3.8861 7.72097 4.01916L5.66291 6.26311C5.2968 6.6623 4.7032 6.6623 4.33709 6.26311L2.27903 4.01916C2.15699 3.88609 2.15699 3.67036 2.27903 3.5373Z"
                                        fill="black" />
                                </svg> */}
                                <div className="group-hover:block hidden z-50 md:-right-16 lg:-right-20 absolute rounded-md top-0 bg-white min-w-[185px] mt-5">
                                    <ul className="bg-white grid gap-4 font-normal md:text-xs lg:text-sm py-[15px] px-[15px] rounded-tl-lg rounded-bl-lg rounded-br-lg text-nowrap">
                                        <li className="cursor-pointer transition-all duration-200 hover:text-blue-500"><a href="#">چرا sanatyariran.com </a></li>
                                        <li className="cursor-pointer transition-all duration-200 hover:text-blue-500"><a href="#">چگونه تامین کنندگان را پیدا کنیم </a></li>
                                        <li className="cursor-pointer transition-all duration-200 hover:text-blue-500"><a href="#">چگونه پرداخت را ایمن کنیم </a></li>
                                        <li className="cursor-pointer transition-all duration-200 hover:text-blue-500"><a href="#">یک شکایت ارسال کنید </a></li>
                                        <li className="cursor-pointer transition-all duration-200 hover:text-blue-500"><a href="#">تماس با ما</a></li>
                                        <li className="cursor-pointer transition-all duration-200 hover:text-blue-500"><a href="#">سوالات متداول</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li className="flex items-center">
                                <a className="pl-1" href="https://sanatyariran.com/sanatyar.apk">اپلیکیشن</a>
                            </li>
                        </ul>
                        <ul className="flex flex-row gap-x-5 relative">
                            <li className="group flex flex-row-reverse  items-center gap-x-2 border-l-2 border-neutral-300 pl-5">همه دسته بندی ها <TfiMenuAlt />
                                <ul className="group-hover:grid hidden grid-cols-2 gap-2 absolute top-4 bg-white z-50 shadow-md  text-xs -right-2 mt-1 px-2 rounded-md py-2">
                                    {categories.map((i) => (
                                        <li className="transition-all duration-200 ease-in-out hover:text-blue-600 flex items-center justify-between py-1 text-nowrap" key={i.id}>
                                            <Link href={`/new/products?category=${i.id}`}>{i.name}</Link>
                                        </li>
                                    ))}
                                </ul>
                            </li>
                            <li></li>
                            <li><Link href="/new/products">محصولات و خدمات</Link></li>
                            <li>مجله صنعت یار</li>
                            <li>درباره ما</li>
                        </ul>
                    </div>
                </div>
                <div className="px-3 pb-3 md:hidden">
                    <div className="bg-gray-200 rounded-2xl">
                        <button className="py-1 px-3">
                            <svg className="inline" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19 19L15.5 15.5M15 8C15 11.866 11.866 15 8 15C4.13401 15 1 11.866 1 8C1 4.13401 4.13401 1 8 1C11.866 1 15 4.13401 15 8Z"
                                    stroke="#909BB0" strokeWidth="2" strokeLinecap="round" />
                            </svg>
                        </button>
                        <input className="bg-inherit text-xs h-full focus:outline-0" value={Search} onKeyDown={SearchHndler} onChange={(e) => setSearch(e.target.value)} style={{ width: "calc(100% - 70px)" }} type="text"
                            placeholder="لطفا نام محصول مورد نظر خود را وارد کنید ... " />
                    </div>
                </div>
            </div>
        </header>
    )
}
