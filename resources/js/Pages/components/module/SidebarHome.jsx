import { TfiMenuAlt } from "react-icons/tfi";
import { useSidebar } from "../../Context/SidebarContext";
import { useState } from "react";
import { Link } from "@inertiajs/react";

export default function SidebarHome({ auth, category }) {

    const [show, setShow] = useState(false)

    const { toggleSidebar, Sidebar } = useSidebar()
    return (
        <div onClick={toggleSidebar} className={`transition-all duration-300 ease-in-out h-screen fixed top-0 bottom-0 right-0 left-0 z-10 overflow-x-hidden  ${Sidebar ? 'w-screen' : "w-0"}`}>
            <div className="w-screen h-screen bg-[#00000080]">
                <div onClick={(e) => e.stopPropagation()} className="w-56 h-screen overflow-auto no-scrollbar bg-white">
                    <div className={`p-3 text-[10px] text-blue-600 ${auth.user ? "hidden" : 'block'}`}>
                        <a href="https://sanatyariran.com/login" className="p-0 m-0 ">وارد شوید</a>
                        <a href="https://sanatyariran.com/login" className="p-0 m-0 mr-7">عضویت رایگان</a>
                    </div>
                    <hr />
                    <div className="py-3 px-6 text-[8px]">
                        <p className="relative text-sm mb-1 flex flex-row items-center gap-x-1 "> <TfiMenuAlt /> دسته بندی</p>
                        <ul className={` transition-all duration-300 ease-in-out overflow-hidden text-[10px] ${show ? 'max-h-[1000px]' : 'max-h-28'} `} >
                            {category.main.map((i) => (
                                <li className="mt-1 text-[12px]" key={i.id} ><Link href={`/new/products?category=${i.id}&per_page=50`}>{i.name}</Link></li>
                            ))}
                            {category.more.map((i) => (
                                <li className="mt-1 text-xs" key={i.id} >{i.name}</li>
                            ))}
                        </ul>

                        <button onClick={() => setShow((perv) => !perv)} href="" className="text-blue-600 block py-3 text-[10px]">موارد بیشتر</button>
                        <hr />
                        {/* <div className="py-2">
                            <a className="text-xs" href="">
                                <img className="inline" src="./images/download (3).svg" alt="" />
                                درخواست منبع پست
                            </a>
                        </div>
                        <hr /> */}
                        <div className="py-2 grid gap-4 text-xs">
                            <a href="https://sanatyariran.com/sanatyar.apk">
                                <img className="inline" src="../images/tablet-outline.svg" alt="" />
                                دریافت اپلیکیشن
                            </a>
                            {/* <a href="">
                                <img className="inline" src="../images/user-headset.svg" alt="" />
                                راهنما
                            </a> */}
                        </div>
                        {/* <hr />
                        <div className="grid gap-2 text-[#727272] pr-4 text-xs">
                            <a href="">قرار داد کاربر</a>
                            <a href="">سیاست حفظ حریم خصوصی</a>
                        </div> */}
                    </div>
                </div>
            </div>
        </div>
    );
}