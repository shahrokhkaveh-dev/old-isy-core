
import { useState } from "react";
import { IoIosArrowDown } from "react-icons/io";

const HTmlRender = ({ code }) => {
    return <div dangerouslySetInnerHTML={{ __html: code }}></div>
}

export default function AboutCompanyPage({ data }) {

    const [Show, setShow] = useState(false)


    return (
        <div>
            <img src={data.brand.logo_path} alt="banner" className=" w-full pt-28 max-h-[576px]  z-20" />
            <div className="bg-white px-8 py-5">
                <h3 className="text-base font-semibold mb-5">برسی اجمالی</h3>
                <HTmlRender code={data.brand.description} />

                {/* <button onClick={() => setShow(!Show)} className="w-fit h-fit mx-auto flex flex-row-reverse items-center text-sm text-blue-500"><IoIosArrowDown className={`${Show ? "rotate-180" : "rotate-0"}`} />{Show ? "کمتر" : 'بیشتر'}</button> */}
            </div>
            <div className="py-5 px-8 bg-white mt-5">
                <h2 className="text-base font-semibold mb-5">اطلاعات شرکت</h2>
                <div>
                    {data.brand.category && <p className="text-neutral-500 sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4"> نوع صنعت : <span className="text-black">{data.brand.category.name}</span></p>}
                    {data.brand.managment_name && <p className="text-neutral-500 sm:text-sm text-xs  flex flex-row gap-x-4 font-light mb-4"> نام مدیر عامل : <span className="text-black">{data.brand.managment_name} </span></p>}
                    {data.brand.phone_number && <p className="text-neutral-500 sm:text-sm text-xs  flex flex-row gap-x-4 font-light mb-4"> شماره تماس : <span className="text-black">{data.brand.phone_number}</span></p>}
                    {data.brand.url && <p className="text-neutral-500 sm:text-sm text-xs  flex flex-row gap-x-4 font-light mb-4"> وب سایت : <span className="text-black">{data.brand.url}</span></p>}
                    <p className="text-neutral-500 sm:text-sm text-xs  flex flex-row gap-x-4 font-light mb-4"> استان / شهر : <span className="text-black">{`${data.brand.province.name} / ${data.brand.city.name} `}</span></p>
                    <p className="text-neutral-500 sm:text-sm text-xs  flex flex-row gap-x-4 font-light mb-4"> آدرس : <span className="text-black">{data.brand.address}</span></p>
                </div>
                <p className="text-sm">ضمانت <span className="text-blue-500">صنعت</span> <span className="text-orange-400">یار</span></p>
            </div>
            {/* <div className="py-5 px-8 bg-white mt-5">
                <h2 className="text-base font-semibold mb-5">اطلاعات تجارت</h2>
                <div>
                    <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4">شرایط تجاری بین المللی : <span className="text-black">لورم ایپسوم متن ساختگی </span></p>
                    <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4">شرایط پرداخت : <span className="text-black">لورم ایپسوم متن ساختگی </span></p>
                    <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4">تعداد : <span className="text-black">لورم ایپسوم متن ساختگی </span></p>
                    <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4">کارکنان بازرگانی خارجی : <span className="text-black">لورم ایپسوم متن ساختگی </span></p>
                </div>
            </div> */}
            {/* <div className="py-5 px-8 bg-white mt-5">
                <h2 className="text-base font-semibold mb-5">اطلاعات صادرات</h2>
                <div>
                    <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4">سال صادرات : <span className="text-black">لورم ایپسوم متن ساختگی </span></p>
                    <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4">درصد صادرات : <span className="text-black">لورم ایپسوم متن ساختگی </span></p>
                    <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4"> بازار های اصلی : <span className="text-black">لورم ایپسوم متن ساختگی </span></p>
                </div>
            </div> */}
            {/* <div className="py-5 px-8 bg-white mt-5">
                <h2 className="text-base font-semibold mb-5">ظرفیت تولیدی</h2>
                <div>
                    <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4"> آدرس کارخانه : <span className="text-black">لورم ایپسوم متن ساختگی </span></p>
                    <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4"> ظرفیت تحقیق و توسعه  : <span className="text-black">لورم ایپسوم متن ساختگی </span></p>
                    <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4">تعداد کارکنان تحقیق و توسعه : : <span className="text-black">لورم ایپسوم متن ساختگی </span></p>
                    <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4"> تعداد خطوط تولید : <span className="text-black">لورم ایپسوم متن ساختگی </span></p>
                    <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4"> ارزش خروجی سالانه : : <span className="text-black">لورم ایپسوم متن ساختگی </span></p>
                </div>
            </div> */}
        </div>
    );
}