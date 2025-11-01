import { Link } from "@inertiajs/react";

export default function ProductCompany({ item }) {
    return (
        <Link href={`/new/product/${item.slug}`} className='transition-all duration-300 ease-in-out hover:shadow-[0px_0px_12px_0px_rgba(0,0,0,0.25)] flex flex-row  md:grid md:grid-rows-2 md:grid-cols-1 py-2 px-3 md:px-3 h-fit w-full bg-neutral-100 md:bg-white ' >
            <div className='md:row-span-1 min-w-[120px]  h-44 bg-zinc-200 rounded-md'>
                <img src={item.image} className="w-full h-full" alt="" />
            </div>
            <div className='md:col-span-1 lg:md:row-span-1 lg:px-2 lg:py-3 flex flex-col w-full overflow-hidden'>
                <p className='truncate  w-full text-neutral-600 lg:my-2 sm:text-sm md:text-sm lg:text-base text-xs '>{item.name}</p>
                {/* <p className='md:text-left mt-2 lg:text-base md:text-sm text-xs sm:text-sm'  >{`(${item.price})`} / قطعه <span className='text-blue-900 font-bold'>{item.x}</span></p> */}
                {/* <p className='text-neutral-600 text-left mt-3 lg:text-sm md:text-xs md:block hidden'>گارانتی : {item.gar} ماه</p> */}
                <p className="md:hidden text-xs bg-zinc-50 border-[1px] border-neutral-200 rounded-md p-1 mt-6 w-fit">با تامین کننده تماس بگیرید</p>
                <button className="bg-blue-600 text-white lg:text-base md:text-sm md:py-1 lg:py-2 w-full rounded-md mt-4">اکنون تماس بگیرید</button>
            </div>
        </Link>
    );
}