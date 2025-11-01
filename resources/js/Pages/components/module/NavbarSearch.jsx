import { BsGrid } from "react-icons/bs";
import { TfiMenuAlt } from "react-icons/tfi";
import { LuFilter } from "react-icons/lu";
import { useSidebar } from "../../Context/SidebarContext";
import { Link } from "@inertiajs/react";

export default function NavbarSearch() {

    const { toggleFilter, filterOpen } = useSidebar()

    const Objparams = Object.fromEntries(new URLSearchParams(window.location.search));

    return (
        <div className='flex flex-row items-center md:items-start   justify-between  md:py-0   px-2 col-span-full'>
            <ul className='flex flex-row  gap-x-3 border-b-[1px] w-full md:gap-x-10 sm'>
                <li aria-checked={window.location.href.includes('products')} className='navbarLinks '><Link data={{ ...Objparams, per_page: window.innerWidth <= 1200 ? 50 : 10, page: 1 }} href={`/new/products`}>لیست محصولات</Link></li>
                <li aria-checked={window.location.href.includes('brands')} className='navbarLinks' ><Link data={{ ...Objparams, per_page: window.innerWidth <= 1200 ? 50 : 10, page: 1 }} href={`/new/brands`}>لیست تامین کننده</Link></li>
            </ul>
            <div className='hidden '>
                <div className='flex-row-reverse bg-stone-200 border-stone-300 border-2 rounded-md h-10 hidden'> <div className='border-l-2 border-stone-300 h-full px-2 flex items-center  '><TfiMenuAlt className='w-6 h-6 text-blue-900 ' /> </div><div className=' h-full px-2 flex items-center '><BsGrid className='w-6 h-6' /> </div></div>
            </div>
            <button onClick={toggleFilter} className="text-xl md:hidden border-r-[1px] border-s border-stone-300 "><LuFilter className="mx-1" /></button>
        </div>
    );
}