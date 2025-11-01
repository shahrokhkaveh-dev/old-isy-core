import { Link, usePage } from "@inertiajs/react";
import { IoIosArrowDown } from "react-icons/io";
import CategorySide from "./components/module/CategorySide";
import MobileCategory from "./components/module/MobileCategory";
import NavbarSearch from "./components/module/NavbarSearch";
import Product from "./components/template/Product";
import { router } from "@inertiajs/react";
import { IoIosClose } from "react-icons/io";


export default function Home({ data }) {

    const params = new URLSearchParams(window.location.search)

    console.log(data)

    const MobilePagenate = () => {
        params.set('page', data.products.current_page + 1)
        params.set("per_page", 50);
        router.get(window.location.pathname + "?" + params.toString(), {}, { replace: true });
    }

    const handleRemoveFilter = (paramKey) => {
        params.delete(paramKey);

        router.get(window.location.pathname + "?" + params.toString(), {}, { replace: true });
    };


    return (
        <>
            <div className='w-full h-f flex flex-col md:px-7 bg-white'>
                {data.resultFor && <p className='text-gray-600 text-sm font-normal text-right my-8 md:block hidden'>نتیجه برای <span className=' mr-2.5 text-black text-2xl font-bold'>{data.resultFor}</span></p>}
                <NavbarSearch />
                <hr className="md:block hidden overflow-x-auto" />
                <div className='md:hidden bg-neutral-100 px-2 py-3 flex flex-row justify-between overflow-x-auto gap-x-16'>
                    {data.products.total > 0 ? <p className='text-xs text-nowrap'><span className='text-blue-600 font-semibold mx-1' >{data.products.total}</span>محصولات <span className='font-semibold'>{data.resultFor}</span></p> : <p className="text-xs text-nowrap">نتیجه ای برای <span>{data.resultFor}</span> پیدا نشد</p>}
                    <ul className="flex flex-row text-[10px] gap-x-4">
                        {Object.keys(data.filters.selectedFilters).map((key, index) => (
                            <>
                                {data.filters.selectedFilters[key] && <li className="flex flex-row text-nowrap" onClick={() => handleRemoveFilter(data.filters.selectedFilters[key].param)} key={index}>{data.filters.selectedFilters[key].label} : {data.filters.selectedFilters[key].value}<IoIosClose className="text-base  text-neutral-700" /></li>}
                            </>
                        ))}

                    </ul>
                </div>
                <div className='w-full h-full'>
                    <div>
                        <div className='md:grid md:grid-cols-5 md:gap-6 w-full md:mt-5 md:bg-white  h-full bg-gray-100'>

                            <CategorySide category={data.filters} />
                            <div className='w-full col-span-4'>
                                {data.products.total > 0 && <Product products={data.products} />}
                            </div>
                        </div>
                    </div>
                </div>



            </div >
            {data.products.current_page !== data.products.last_page &&
                <div className=" border-b-[1px] border-neutral-300   py-3 md:hidden bg-white mt-3">
                    <button disabled={data.products.current_page == data.products.last_page} onClick={MobilePagenate} className=" text-base w-full flex flex-row-reverse gap-1 justify-center items-center "><IoIosArrowDown />موارد بیشتر</button>
                </div>
            }

            <MobileCategory filters={data.filters} />
        </>
    );
}
