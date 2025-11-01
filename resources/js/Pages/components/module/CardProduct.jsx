import { Link } from "@inertiajs/react";

export default function CardProduct({ item }) {

    return (
        <Link href={`/new/peoduct/${item.slug}`} className='flex flex-row md:grid md:grid-rows-3 md:grid-cols-1 py-2 px-3 md:px-0 md:py-0 md:border-[1px] border-neutral-500 w-full bg-neutral-100 md:bg-white'>
            <div className='md:row-span-2 min-w-[120px] md:w-full bg-zinc-200'>
                <img className="w-full h-full" src={item.image} alt="" />
            </div>
            <div className='md:col-span-1 md:row-span-1 px-2 py-3 flex flex-col w-full overflow-hidden'>
                <p className='truncate  w-full text-neutral-600 my-2 sm:text-sm md:text-sm lg:text-base text-xs '>{item.description}</p>
                {/* <p className='md:text-left mt-2 lg:text-base md:text-sm text-xs sm:text-sm'>{`(${item.price})`} / قطعه <span className='text-blue-900'>{item.x}</span></p>
                <p className='text-neutral-600 text-left mt-3 lg:text-sm md:text-xs md:block hidden'>گارانتی : {item.gar} ماه</p> */}
                <p className="md:hidden text-xs bg-zinc-50 border-[1px] border-neutral-200 rounded-md p-1 mt-6 w-fit">با تامین کننده تماس بگیرید</p>
            </div>
        </Link>
    );
}