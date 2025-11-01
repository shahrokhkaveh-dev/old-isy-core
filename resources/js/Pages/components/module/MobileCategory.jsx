import { useState } from "react";
import { useSidebar } from "../../Context/SidebarContext";
import { IoIosArrowDown } from "react-icons/io";
import { IoIosArrowUp } from "react-icons/io";
import { router } from "@inertiajs/react";

export default function MobileCategory({ filters }) {

    const params = new URLSearchParams(window.location.search)

    const chekBoxFilter = (event, key) => {

        params.set(key, event.target.value)
        params.set("per_page", 50)
        router.get(window.location.pathname + "?" + params.toString(), {}, { replace: true });
    }


    const [Open, setOpen] = useState({ category: false, county: false, city: false, iparks: false })
    const { toggleFilter, filterOpen } = useSidebar()

    return (
        <div onClick={toggleFilter} className={`transition-all h-full flex justify-end overflow-y-auto overflow-x-hidden ease-in-out duration-300 backdrop-brightness-75 md:hidden left-0 fixed top-0 ${filterOpen ? 'w-full' : 'w-0'}`}>
            <div onClick={(e) => e.stopPropagation()} className="w-[75%] h-full overflow-y-auto py-2 bg-white">
                <div aria-disabled={Open.category} className="transition-all  duration-500 ease-in-out aria-disabled:max-h-[1000px] max-h-16 border-b-[1px] border-neutral-300  overflow-hidden px-2">
                    <button onClick={() => setOpen((perv) => ({ ...perv, category: !Open.category }))} className="btnfilter"> {Open.category ? <IoIosArrowUp /> : <IoIosArrowDown />}دسته بندی</button>
                    <ul className="bg-slate-50 mt-3 py-1">
                        {filters.categories && filters.categories.items.map((i) => (
                            <li className="my-2 w-full flex flex-row justify-between" key={i.id} >
                                <label htmlFor={i.id}>{i.name}</label>
                                <input className=" appearance-none px-1 outline-offset-1 checked:bg-blue-500 outline outline-1 rounded-full w-2 h-2 ml-2 outline-black" onChange={(e) => chekBoxFilter(e, "category")} checked={params.get("category") == i.id} value={i.id} type="radio" name={i.id} id={i.id} />
                            </li>
                        ))}
                    </ul>
                </div>
                <div aria-disabled={Open.county} className="transition-all duration-500 ease-in-out aria-disabled:max-h-[1000px]  max-h-16 border-b-[1px] border-neutral-300  overflow-hidden px-2">
                    <button onClick={() => setOpen((perv) => ({ ...perv, county: !Open.county }))} className="btnfilter"> <IoIosArrowDown />استان</button>
                    <ul className="bg-slate-50 mt-3 py-1">
                        {filters.provinces && filters.provinces.map((i) => (
                            <li className="my-2 w-full flex flex-row justify-between" key={i.id} >
                                <label htmlFor={i.id}>{i.name}</label>
                                <input className=" appearance-none px-1 rounded-full outline-offset-1 checked:bg-blue-500 outline outline-1 w-2 h-2 ml-2 outline-black" type="radio" onChange={(e) => chekBoxFilter(e, "province")} value={i.id} name={i.id} id={i.id} />
                            </li>
                        ))}
                    </ul>
                </div>
                <div aria-disabled={Open.city} className="transition-all duration-500 ease-in-out aria-disabled:max-h-[1000px]  max-h-16 border-b-[1px] border-neutral-300  overflow-hidden px-2">
                    <button onClick={() => setOpen((perv) => ({ ...perv, city: !Open.city }))} className="btnfilter"> <IoIosArrowDown />شهر</button>
                    {filters.cities ?
                        <ul className="bg-slate-50 mt-3 py-1">
                            {filters.cities.map((i) => (
                                <li className="my-2 w-full flex flex-row justify-between" key={i.id} >
                                    <label htmlFor={i.id}>{i.name}</label>
                                    <input className=" appearance-none px-1 outline-offset-1 checked:bg-blue-500 outline outline-1 w-2 h-2 ml-2 outline-black rounded-full" onChange={(e) => chekBoxFilter(e, "city")} type="radio" value={i.id} name={i.id} id={i.id} />
                                </li>
                            ))}
                        </ul>
                        :
                        <p className="text-red-500 mt-2">لطفا استان را انتخاب کنید</p>
                    }
                </div>
                <div aria-disabled={Open.iparks} className="transition-all duration-500 ease-in-out aria-disabled:max-h-[1000px]  max-h-16 border-b-[1px] border-neutral-300  overflow-hidden px-2">
                    <button onClick={() => setOpen((perv) => ({ ...perv, iparks: !Open.iparks }))} className="btnfilter"> <IoIosArrowDown />شهر صنعتی</button>
                    {filters.iparks ?
                        <ul className="bg-slate-50 mt-3 py-1">
                            {filters.iparks.map((i) => (
                                <li className="my-2 w-full flex flex-row justify-between" key={i.id} >
                                    <label htmlFor={i.id}>{i.name}</label>
                                    <input className=" appearance-none px-1 outline-offset-1 checked:bg-blue-500 outline outline-1 w-2 h-2 ml-2 outline-black rounded-full" onChange={(e) => chekBoxFilter(e, "ipark")} type="radio" value={i.id} name={i.id} id={i.id} />
                                </li>
                            ))}
                        </ul>
                        :
                        <p className="text-red-500 mt-2">لطفا استان را انتخاب کنید</p>
                    }
                </div>

            </div>
        </div>
    );
}