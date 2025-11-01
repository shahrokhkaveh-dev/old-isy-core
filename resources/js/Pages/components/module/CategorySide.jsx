import { Fragment, useState } from "react";
import { IoIosArrowDown } from "react-icons/io";
import { IoSearchSharp } from "react-icons/io5";
import { IoMdClose } from "react-icons/io";
import { Link } from "@inertiajs/react";
import { router } from "@inertiajs/react";


export default function CategorySide({ category }) {

    const [Search, setSearch] = useState({ provience: '', city: "", ipark: '' })

    const Objparams = Object.fromEntries(new URLSearchParams(window.location.search));

    const params = new URLSearchParams(window.location.search)

    const handleRemoveFilter = (paramKey) => {
        params.delete(paramKey);

        router.get(window.location.pathname + "?" + params.toString(), {}, { replace: true });
    };

    const chekBoxFilter = ({ event, key }) => {

        if (!params.get('is_exportable')) {
            params.set(key, event.target.value)
            router.get(window.location.pathname + "?" + params.toString(), {}, { replace: true });
        } else {
            params.delete('is_exportable')
            router.get(window.location.pathname + "?" + params.toString(), {}, { replace: true });
        }
    }



    const [show, setShow] = useState(false)


    return (
        <div className={`md:block hidden  col-span-1 sticky top-0 md:h-screen md:w-full  border-[1px]  border-neutral-300 md:py-5 md:px-6 overflow-auto `}>
            <div className="border-b-[1px] border-neutral-300 border-dashed pb-5 sticky">
                <ul>
                    {Object.keys(category.selectedFilters).map((key) => (

                        <>
                            {category.selectedFilters[key] && <li onClick={() => handleRemoveFilter(category.selectedFilters[key].param)} className="text-xs my-2 text-neutral-500 bg-neutral-200 w-fit px-1 py-[1px] rounded-md cursor-pointer"><IoMdClose className="inline mr-1" />{category.selectedFilters[key].label} : {category.selectedFilters[key].value} </li>}
                        </>

                    ))}


                </ul>
                <ul className={`transition-all ease-in-out duration-200 overflow-hidden ${show ? 'max-h-[1000px]' : 'max-h-56'}`}>
                    <li className="mb-2 text-lg font-bold flex flex-col-reverse">دسته بندی</li>
                    {category?.categories.items.map((i) => (
                        <li className="filterlitst" key={i.id}>
                            <Link data={{ ...Objparams, category: i.id, page: 1, }}>{i.name}</Link>
                        </li>
                    ))}
                </ul>
                <button onClick={() => setShow(!show)} className="h-fit w-fit text-sm text-neutral-500 border-[1px] rounded-lg border-neutral-300 px-2 mt-5">{!show ? "بیشتر" : "کمتر"} <IoIosArrowDown className={`transition-all duration-300 ease-in-out  w-fit inline text-base ml-2 ${show ? 'rotate-180' : 'rotate-0'}`} /></button>
            </div>
            <div className="mt-4">
                <p className="text-black text-base font-semibold mb-1">ویژگی های محصول</p>
                <div className="cursor-pointer">
                    <input checked={params.get('is_exportable')} onClick={(e) => chekBoxFilter({ event: e, key: "is_exportable" })} className=" appearance-none px-1 outline-offset-1 checked:bg-blue-500 outline outline-1 w-2 h-2 ml-2 outline-black" type="radio" name="guarantee" id="guarantee" value={true} />
                    <label htmlFor="guarantee" className="text-sm cursor-pointer">محصولات صادراتی</label>
                </div>
            </div>
            <div className="mt-4">
                <p className="text-base font-bold mb-1">استان</p>
                <div className="transition-all text-sm ease-in-out duration-200 border-[1px] h-7 border-neutral-300 rounded-md flex flex-row w-full  hover:border-neutral-400 overflow-hidden">
                    <input onChange={(e) => setSearch((perv) => ({ ...perv, provience: e.target.value }))} className="transition-all duration-100 ease-in-out w-full  focus:outline-none focus:border-2 focus:border-blue-500 " type="text" />
                    <button className="transition-all duration-200 ease-in-out bg-gray-200 text-neutral-500 px-2 text-xl hover:bg-gray-300"><IoSearchSharp /></button>
                </div>
                <ul className="max-h-56 overflow-y-auto ">
                    {category.provinces.map((i) => (
                        <>
                            {Search.provience ?
                                <>
                                    {i.name.includes(Search.provience) && <li key={i.id} className="filterlitst"><Link data={{ ...Objparams, province: i.id }}>{i.name}</Link></li>}
                                </>

                                :
                                <li key={i.id} className="filterlitst"><Link data={{ ...Objparams, province: i.id }}>{i.name}</Link></li>
                            }
                        </>
                    ))}

                </ul>
            </div>
            <div className="mt-4">
                <p className="text-base font-bold mb-1">شهر</p>
                <div className="transition-all text-sm ease-in-out duration-200 border-[1px] h-7 border-neutral-300 rounded-md flex flex-row w-full  hover:border-neutral-400 overflow-hidden">
                    <input onChange={(e) => setSearch((perv) => ({ ...perv, city: e.target.value }))} className="transition-all duration-100 ease-in-out w-full px-1  focus:outline-none focus:border-2 focus:border-blue-500 " type="text" />
                    <button className="transition-all duration-200 ease-in-out bg-gray-200 text-neutral-500 px-2 text-xl hover:bg-gray-300"><IoSearchSharp /></button>
                </div>
                <ul className="overflow-y-auto max-h-56">
                    {category.cities ?
                        <>
                            {category.cities.map((i) => (
                                <>
                                    {Search.city ?
                                        <Fragment key={i.id}>
                                            {i.name.includes(Search.city) && <li className="filterlitst"><Link data={{ ...Objparams, city: i.id }}>{i.name}</Link></li>}
                                        </Fragment>

                                        :
                                        <li className="filterlitst"><Link key={i.id} data={{ ...Objparams, city: i.id }}>{i.name}</Link></li>
                                    }
                                </>
                            ))}
                        </>
                        :
                        <li className=" text-red-500 py-1 px-2 text-sm mt-1" >لطفا استان را انتخاب کنید</li>
                    }
                </ul>
            </div>
            <div className="mt-4">
                <p className="text-base font-bold mb-1">شهر صنعتی</p>
                <div className="transition-all text-sm ease-in-out duration-200 border-[1px] h-7 border-neutral-300 rounded-md flex flex-row w-full  hover:border-neutral-400 overflow-hidden">
                    <input onChange={(e) => setSearch((perv) => ({ ...perv, ipark: e.target.value }))} className="transition-all duration-100 ease-in-out px-1 w-full  focus:outline-none focus:border-2 focus:border-blue-500 " type="text" />
                    <button className="transition-all duration-200 ease-in-out bg-gray-200 text-neutral-500 px-2 text-xl hover:bg-gray-300"><IoSearchSharp /></button>
                </div>
                <ul className="max-h-56 overflow-y-auto">
                    {category.iparks ?
                        <>
                            {category.iparks.map((i) => (
                                <>
                                    {Search.ipark ?
                                        <Fragment key={i.id}>
                                            {i.name.includes(Search.ipark) && <li className="text-sm text-neutral-500 mt-1"><Link data={{ ...Objparams, ipark: i.id }}>{i.name}</Link></li>}
                                        </Fragment>

                                        :
                                        <li className="text-sm text-neutral-500 mt-1"><Link key={i.id} data={{ ...Objparams, ipark: i.id }}>{i.name}</Link></li>
                                    }
                                </>
                            ))}
                        </>
                        :
                        <li className=" text-red-500 py-1 px-2 text-sm mt-1" >لطفا استان را انتخاب کنید</li>
                    }
                </ul>
            </div>
        </div>
    );
}