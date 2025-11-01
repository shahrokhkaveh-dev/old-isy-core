import { useState } from "react";
import { IoIosArrowDown } from "react-icons/io";

export default function MobileNavbarCompany({ setPage, Page, data }) {

    console.log(data)

    const [show, setShow] = useState(false)

    const link = [
        { title: "صفحه اصلی", id: 1 },
        // { title: "محصول", id: 2 },
        { title: " درباره شرکت ", id: 3 },
        { title: "تماس بگیرید", id: 4 },
    ]

    return (
        <div className="">
            <div className="bg-[url('https://sanatyariran.com/banner/banner.png')] w-full sm:h-64 min-h-40 bg-cover flex flex-col justify-between py-5 sm:px-6 px-1">
                <div className="mx-auto w-fit backdrop-brightness-75  py-5 sm:px-4 sm:gap-x-3 gap-x-2 ">
                    <div className="flex flex-row items-center">
                        <img className="sm:w-[75px] sm:h-[72px] w-10 h-10" src={data.brand.logo_path} alt="" />
                        <div className="flex flex-col  mr-2">
                            <h3 className="text-white text-sm sm:text-lg font-bold">{data.brand.name}</h3>
                            {/* <div className="flex flex-row gap-x-2 sm:gap-x-3 sm:items-center">
                                <p className="sm:text-xs text-[10px] text-nowrap  flex flex-row-reverse w-fit text-white gap-x-1 ">تامین کننده حساب رسی شده <img className="sm:w-auto sm:h-auto w-3 h-3" src="./icon/a.svg" alt="" /></p>
                                <p className="sm:text-xs text-[10px] text-nowrap flex flex-row-reverse w-fit text-white gap-x-1">سال تاسیس1408 <img src="./icon/b.svg" alt="" /></p>
                                <button onClick={() => setShow(!show)} className="text-white  sm:flex hidden text-sm font-light  flex-row items-center text-[10px] mr-2 sm:self-baseline self-end mb-1">{show ? "کمتر" : "بیشتر"}<IoIosArrowDown className={`transition-all ease-in-out duration-300 ${show ? "rotate-180" : "rotate-0"}`} /></button>
                            </div> */}
                        </div>
                        {/* <button onClick={() => setShow(!show)} className="text-white sm:hidden font-light flex flex-row items-center text-[10px] mr-2 sm:self-baseline self-end mb-1">{show ? "کمتر" : "بیشتر"}<IoIosArrowDown className={`transition-all ease-in-out duration-300 ${show ? "rotate-180" : "rotate-0"}`} /></button> */}
                    </div>
                    <div className={` transition-all ease-in-out duration-200 ${show ? "max-h[1000px]" : 'max-h-0'} overflow-hidden flex gap-2  flex-row flex-wrap`}>
                        <p className="text-white text-[10px]">نوع کسب و کار : <span>لورم ایپسوم متن  </span></p>
                        <p className="text-white text-[10px]">محصول اصلی : <span>لورم ایپسوم متن </span></p>
                        <p className="text-white text-[10px]">سال تاسیس : <span>1383</span></p>
                        <p className="text-white text-[10px]">گواهینامه : <span>لورم ایپسوم متن </span> </p>
                        <p className="text-white text-[10px]">تعداد کارمندان : <span>لورم ایپسوم متن </span> </p>
                        <p className="text-white text-[10px]">میان گین زمان تحویل: <span>لورم ایپسوم متن </span> </p>
                    </div>

                </div>
                <div className="flex flex-row gap-x-2">
                    <ul className={`transition-all duration-200 ease-in-out text-sm flex flex-row gap-x-5 items-center w-full flex-wrap overflow-hidden  max-h-10 gap-y-4`}>
                        {link.map((i) => (
                            <li onClick={() => setPage(i.id)} key={i.id} className="text-white  w-fit flex flex-col items-center sm:text-base text-xs text-nowrap ">{i.title}<span aria-checked={i.id == Page} className=" w-3/4 hidden aria-checked:block bg-white h-[2px] mt-1" ></span></li>
                        ))}
                    </ul>

                </div>
            </div>

        </div>
    );
}