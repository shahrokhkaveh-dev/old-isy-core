import { Link } from "@inertiajs/react";

export default function MobileCategoryNav({ data }) {

    return (
        <div className="px-3 md:hidden">
            <ul id="category" className="flex gap-8 flex-row overflow-auto no-scrollbar ">
                {data.main.map((i) => (
                    <li key={i.id} className="text-[10px] sm:text-xs py-2 text-nowrap hover:text-blue-600 hover:border-b-2 hover:border-blue-600"><Link href={`/new/products?category=${i.id}&per_page=50`}>{i.name}</Link></li>
                ))}
            </ul>
        </div>
    );
}