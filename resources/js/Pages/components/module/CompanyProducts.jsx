import { useState } from "react";
import { IoIosArrowDown } from "react-icons/io";

export default function CompanyProducts({ data }) {

    const [showproducts, setShowProducts] = useState(false)




    return (
        <section className="flex flex-col p-5 rounded-md w-11/12 mx-auto z-20 relative bg-white">
            <div className={`transition-all gap-y-2 duration-200 ease-in-out flex flex-col w-full ${showproducts ? 'max-h-[1000PX]' : 'max-h-96'} overflow-hidden`}>
                {data.map((i) => (
                    <div key={i.id} className="flex flex-row justify-between sm:p-3 p-1 py-7 items-center">
                        <div className="flex flex-row sm:gap-x-5 gap-x-3">
                            <img src={i.image} alt="iamge" className="bg-zinc-400 w-24 sm:w-[75px] min-h-full" />
                            <div className="flex flex-col gap-y-4">
                                <p className="text-neutral-500 text-sm">{i.name}</p>
                                {/* <p className="text-xs text-nowrap flex flex-row"><span className="text-blue-500">396</span>قطعه / <p>{"(تومان ایران)"}</p></p> */}
                                <button className="text-white bg-blue-500 text-xs text-nowrap sm:text-sm h-fit rounded-md p-1 font-light sm:hidden">با تامین کننده تماس بگیرید</button>
                            </div>
                        </div>
                        <button className="text-white bg-blue-500 text-xs  sm:text-sm h-fit rounded-md p-1 font-light hidden sm:block">با تامین کننده تماس بگیرید</button>
                    </div>
                ))}
            </div>
            <button onClick={() => setShowProducts(!showproducts)} className="w-fit h-fit mx-auto flex flex-row-reverse items-center text-sm text-blue-500"><IoIosArrowDown className={`${showproducts ? "rotate-180" : "rotate-0"}`} />{showproducts ? "کمتر" : 'بیشتر'}</button>

        </section>
    );
}