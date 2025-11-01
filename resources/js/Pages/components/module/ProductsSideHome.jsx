import { Link } from "@inertiajs/react";
import { TbTargetArrow } from "react-icons/tb";
import { LazyLoadImage } from "react-lazy-load-image-component";

export default function ({ products }) {

    return (
        <div className="w-fit min-w-80 px-2 flex flex-col gap-y-8 ">
            {products.map((i) => (
                <Link href={`/new/product/${i.slug}`} key={i.id} className="flex flex-row gap-x-2 items-center">
                    <LazyLoadImage className=" lg:w-[100px] lg:min-w-[100px] lg:h-[90px] md:w-[60px] md:min-w-16 md:h-12" src={i.image} alt={i.image} />
                    <p className="lg:text-base md:text-sm">{i.name}</p>
                </Link>
            ))}
            <div>
                <p className=" mb-5 text-sm">محصول مطلوبی ندارید؟</p>
                <button className="flex flex-row-reverse text-sm border-2 border-blue-600 text-blue-500 items-center p-1">درخواست خود را ارسال کنید <TbTargetArrow className="text-xl ml-2 text-black" /></button>
            </div>
        </div>
    );
}