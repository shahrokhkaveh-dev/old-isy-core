import { useState } from "react";


export default function Catogiry() {
    const [show, setshow] = useState(false)

    const x = [
        "محصولات", "محصولات", "محصولات", "محصولات", "محصولات", "محصولات",
    ]

    return (
        <div className=' md:flex hidden flex-row items-baseline overflow-hidden border-[1px] h-f border-neutral-300 border-t-0 px-5 py-3'>
            <ul className={`flex flex-row flex-nowrap overflow-hidden gap-x-8  relative h-fit`}>
                {x.map((text, index) => (
                    <li className='border-2 border-stone-300 px-6 py-2 rounded-md text-neutral-500 text-sm  ' key={index}>{text}</li>
                ))}
            </ul>

        </div>
    );
}