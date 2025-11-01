import { Link, router } from "@inertiajs/react";
import { IoIosArrowDown } from "react-icons/io";

export default function Pagenate({ products }) {

    const params = new URLSearchParams(window.location.search)



    const handlePerPage = (per) => {
        params.set("per_page", per);

        router.get(window.location.pathname + "?" + params.toString(), {}, { replace: true });
    };

    function getQueryParams(url) {
        if (!url) return
        const queryString = url.split('?')[1] || '';
        return Object.fromEntries(new URLSearchParams(queryString));
    }

    const MobilePagenate = () => {
        params.set('page', products.current_page + 1)
        params.set("per_page", 50);
        router.get(window.location.pathname + "?" + params.toString(), {}, { replace: true });
    }


    return (
        <>
            {products.current_page !== products.last_page &&
                <div className=" border-b-[1px] border-neutral-300   py-3 md:hidden bg-white mt-3">
                    <button disabled={products.current_page == products.last_page} onClick={MobilePagenate} className=" text-base w-full flex flex-row-reverse gap-1 justify-center items-center "><IoIosArrowDown />موارد بیشتر</button>
                </div>
            }

            <div className=" flex-row-reverse justify-between w-full hidden md:flex px-8 border-[1px] border-neutral-300 border-t-0 py-3">
                <div className="flex flex-row gap-x-2">
                    {products.links.map((i) => (
                        <Link aria-checked={i.active} className={`aria-checked:border-none aria-checked:text-blue-600 border-[1px] border-gray-300 text-gray-500 px-2 min-w-7 text-center py-[2px] rounded-md ${i.url ? "" : 'pointer-events-none opacity-70'}`} data={getQueryParams(i.url)} >{i.label}</Link>
                    ))}
                </div>
                <div className=" flex flex-row gap-x-3">
                    <p className="text-neutral-500"> نمایش :</p>
                    <div>
                        <button className="text-neutral-500 px-3 border-l-[1px] border-neutral-500 aria-checked:text-blue-600" aria-checked={products.per_page == 10} onClick={() => handlePerPage(10)}>10</button>
                        <button className="text-neutral-500 px-3 border-l-[1px] border-neutral-500 aria-checked:text-blue-600" aria-checked={products.per_page == 20} onClick={() => handlePerPage(20)}>20</button>
                        <button className="text-neutral-500 px-3   aria-checked:text-blue-600" aria-checked={products.per_page == 30} onClick={() => handlePerPage(30)}>30</button>
                    </div>
                </div>
            </div>
        </>
    );
}