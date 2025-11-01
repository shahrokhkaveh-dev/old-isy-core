import { useState } from "react";

export default function NavbarProduct() {

    const [item, setItem] = useState('')

    const x = [
        'محصولات منتخب', 'لورم ایپسوم متن ', 'لورم ایپسوم متن ', 'لورم ایپسوم متن ', 'لورم ایپسوم متن ', 'لورم ایپسوم متن '
    ]

    return (
        <div className=" w-full pt-2 md:shadow-none shadow-[0px_3px_5px_-3px_rgba(0,0,0,0.25)] md:mb-0 mb-3">
            <ul className="w-full md:w-fit flex flex-row gap-x-7 mx-auto overflow-x-auto  ">
                {x.map((i, index) => (
                    <li aria-checked={i == item} onClick={() => setItem(i)} className="transition-all duration-75 ease-in-out text-neutral-500 text-xs text-nowrap md:text-base aria-checked:text-blue-600 border-blue-600 aria-checked:border-b-2 py-2 " key={index}>{i}</li>
                ))}
            </ul>
        </div>
    );
}