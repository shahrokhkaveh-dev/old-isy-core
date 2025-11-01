import { IoIosArrowBack } from "react-icons/io";
import { FaRegEnvelope } from "react-icons/fa6";
import { LazyLoadImage } from "react-lazy-load-image-component";
import { Link } from "@inertiajs/react";
import Pagenate from "../module/Pagenate";

export default function Product({ products }) {


    return (
        <>
            <div className="flex flex-col gap-y-2 bg-transparent">
                {products.data.map((i) => (

                    <Link href={`/new/product/${i.slug}`} key={i.id} className="flex flex-row md:border-[1px] gap-x-2 md:gap-x-3 border-neutral-300  p-2 overflow-hidden w-full bg-white ">

                        <LazyLoadImage src={i.image} alt="image" className="w-36 h-36 object-cover" />

                        <div className="w-[40%] md:w-full flex flex-col">
                            <p className="text-neutral-500 text-xs sm:text-sm md:text-base  my-2 md:my-4 w-full truncate">{i.name}</p>
                            {/* <p className="text-blue-600 md:text-sm sm:text-xs text-[10px] text-nowrap md:mb-4" >14,000000000,000 {'(تومان اران)'} <span className="text-neutral-500">کیلو گرم</span></p>
                        <p className="text-[10px] sm:text-xs text-neutral-500 my-2 md:mb-4 md:block hidden" >حداقل مقدار سفارش (MOQ): ۴۰۰۰ کیلوگرم</p> */}
                            <div className=" flex-row flex-wrap gap-y-4  gap-x-24 md:flex hidden w-full">
                                {i.attributes.map((item) => (
                                    <p className="titletext">{item.name} : <span className="text-black">{item.value}</span></p>
                                ))}
                            </div>

                            <div className="md:flex hidden  flex-row gap-x-24 mt-3    w-full">
                                <div className="md:flex hidden flex-row justify-between items-end py-2 md:border-t-[1px] border-dashed border-neutral-300 w-full">
                                    <p className=" flex-row-reverse w-fit items-end gap-2 text-neutral-500 text-sm my-1  md:flex hidden "> <IoIosArrowBack className="text-sm" />{i.brand_name}</p>
                                    <p className="bg-blue-600 md:flex text-sm hidden text-white  flex-row gap-1 items-center rounded-md px-2 py-2"><FaRegEnvelope className="text-lg" />اکنون استعلام بگیرید</p>
                                </div>
                            </div>
                            {/* <p className="md:hidden text-[10px] text-neutral-500 my-2">تعداد : <span >1 قطعه</span></p> */}
                            <p className="text-xs text-nowrap w-fit bg-zinc-50 border-neutral-200 border-2 rounded-md p-1 md:hidden"> از تامین کننده استعلام بگیرید</p>
                        </div>
                    </Link>
                ))}

            </div>
            <Pagenate products={products} />
        </>
    );
}