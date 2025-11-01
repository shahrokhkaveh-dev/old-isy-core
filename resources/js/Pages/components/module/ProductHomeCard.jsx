import { Link } from "@inertiajs/react";
import { LazyLoadImage } from "react-lazy-load-image-component";

export default function ProductHomeCard({ item }) {

    return (
        <Link href={`/new/product/${item.slug}`} key={item.id} className="text-center w-full justify-end flex flex-col">
            <LazyLoadImage src={item.image} alt="" className=" object-cover  mx-auto md:h-[76px] md:w-32 lg:w-44 min-w-44 min-h-44 lg:h-44" />
            <div className="flex justify-center pt-5  row-span-2 w-full h-full">
                <h3 className="text-base text-[#1E1E1E] text-center min-w-fit min-h-fit">
                    {item.name}
                </h3>
            </div>
        </Link>
    );
}
