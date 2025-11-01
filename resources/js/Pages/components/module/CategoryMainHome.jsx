import { TfiMenuAlt } from "react-icons/tfi";
import { IoIosArrowBack } from "react-icons/io";
import { useState } from "react";
import { Link } from "@inertiajs/react";

export default function CategoryMainHome({ category }) {
    const [childs, setChilds] = useState()
    const [show, setShow] = useState(false)
    const [morechilds, setMoreChilds] = useState('')

    return (
        <>
            <ul style={{
                'listStyle': "none"
            }} onMouseLeave={() => setChilds('')} className="w-fit px-2 overflow-visible ">
                <li className="text-lg font-semibold flex flex-row items-center gap-x-1 text-neutral-900"> <TfiMenuAlt /> دسته بندی ها</li>
                {category.main.map((i) => (
                    <li aria-checked={childs && childs[0].parent_id == i.id} onMouseEnter={() => setChilds(i.childs)} className="transition-all duration-200 ease-in-out cursor-pointer aria-checked:bg-blue-50 aria-checked:text-blue-600 hover:text-blue-600 lg:text-base md:text-sm  text-nowrap my-[6px] py-1 hover:bg-blue-50 " key={i.id}>
                        <Link className={`${i.name.length > 30 ? 'lg:text-sm md:text-xs ' : null}`} href="/new/products" data={{ category: i.id }}>{i.name}</Link>

                    </li>
                ))}
                <li onMouseEnter={() => { setShow(true), setChilds('') }} onMouseLeave={() => setShow(false)} className="text-blue-500 lg:text-base md:text-sm flex flex-row items-center  gap-2 py-1 hover:bg-blue-50">موارد بیشتر <IoIosArrowBack />
                    {show &&
                        <div className="lg:w-8/12 shadow-md md:w-10/12 h-full min-h-full bg-white  md:right-[177px] lg:right-[207px] top-0 absolute overflow-y-auto flex flex-row z-50">
                            <ul className="w-fit bg-neutral-600 min-h-full text-white pr-2">
                                {category.more.map((i) => (
                                    <li key={i.id} aria-checked={morechilds && morechilds[0].parent_id == i.id} onMouseEnter={() => setMoreChilds(i.childs)} className="transition-all duration-200 ease-in-out aria-checked:bg-white aria-checked:text-black hover:text-black hover:bg-white min-w-52 my-3 font-light px-1 ">
                                        <Link data={{ category: i.id }} href="/new/products">{i.name}</Link>
                                    </li>
                                ))}
                            </ul>
                            <div className="bg-white">
                                {morechilds &&
                                    <ul className="text-black bg-white flex flex-row gap-3 flex-wrap justify-between w-full py-3 px-10 min-h-full">
                                        {morechilds.map((item) => (
                                            <li className="flex flex-col md:min-w-52 lg:min-w-64 h-fit" key={item.id}>
                                                <Link data={{ category: item.id }} href="/new/products" className="lg:text-xl text-lg font-semibold" >{item.name}</Link>
                                                <ul className="text-sm">
                                                    {item.childs.map((i) => (
                                                        <li className="transition-all duration-200 ease-in-out cursor-pointer hover:text-blue-600 my-2 font-normal lg:text-base" key={i.id}>
                                                            <Link data={{ category: item.id }} href="/new/products">{i.name}</Link>
                                                        </li>
                                                    ))}
                                                </ul>
                                            </li>
                                        ))}
                                    </ul>
                                }
                            </div>
                        </div>
                    }

                </li>
                <li>


                </li>
                <li>{childs && <div className="lg:w-8/12 md:w-9/12 shadow-md overflow-y-auto bg-white md:right-[180px] lg:right-[208px] top-0 absolute h-full z-50">
                    <ul className="px-7 text-sm flex flex-row flex-wrap gap-x-36">
                        {childs.map((i) => (
                            <li className="flex flex-col md:min-w-52 lg:min-w-64" key={i.id}>
                                <Link data={{ category: i.id }} href="/new/products" className="lg:text-xl text-lg font-semibold">{i.name}</Link>
                                <ul>
                                    {i.childs.map((item) => (
                                        <li className="transition-all duration-200 ease-in-out cursor-pointer hover:text-blue-600 my-2 font-normal lg:text-base" key={item.id}><Link data={{ category: item.id }} href="/new/products">{item.name}</Link></li>
                                    ))}
                                </ul>
                            </li>
                        ))}
                    </ul>
                </div>}</li>
            </ul>

        </>
    );
}