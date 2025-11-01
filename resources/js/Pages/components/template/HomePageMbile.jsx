import { Link } from "@inertiajs/react";
import MobileNavbarHome from "../module/MobileNavbarHome";

export default function HomePageMbile({ data }) {


    return (
        <div className=" md:hidden bg-gray-100">
            <MobileNavbarHome banner={data.section1.banners} />
            <div className="flex flex-row justify-around w-full overflow-x-auto py-2">
                {data.section1.products.slice(0, 3).map((i) => (
                    <Link href={`/new/product/${i.slug}`} className=" overflow-hidden min min-w-[90px] w-[90px]">
                        <img src={i.image} className="bg-zinc-300 w-full h-24 " alt="" />
                        <p className="max-w-full truncate text-nowrap text-xs text-neutral-800">{i.name}</p>
                    </Link>
                ))}

            </div>
        </div>
    );
}