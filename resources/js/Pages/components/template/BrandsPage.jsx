import Pagenate from "../module/Pagenate";
import { FaRegEnvelope } from "react-icons/fa";
import { MdOutlineShoppingCart } from "react-icons/md";
import NavbarSearch from "../module/NavbarSearch";
import { Link } from "@inertiajs/react";

export default function BrandsPage({ brands }) {

    return (
        <div className="w-full h-full col-span-full md:col-span-4 mt-6">

            <div className="w-full h-full flex flex-col">
                {brands.data.map((i) => (
                    <Link href={`/new/company/${i.slug}`} key={i.id} className="grid  grid-cols-1 w-full sm:grid-cols-3 border-b-[1px] p-5 md:h-80 md:min-h-80 lg:h-96 lg:min-h-96">
                        <div className="flex flex-col gap-y-4 sm:col-span-1">
                            <p className="flex flex-row items-center text-blue-900 sm:text-sm md:text-xl text-wrap">{i.logo_path && <img className="md:w-16 w-12 sm:w-11 md:ml-2" src={i.logo_path} alt="" />} {i.name} </p>
                            <p className="md:text-base sm:text-sm text-neutral-600">شهر / استان: <span className="text-black">{i.province_name || i.city_name}</span></p>
                            <button className="text-white bg-blue-600 rounded-md sm:text-xs md:text-sm p-1 w-fit  "> <FaRegEnvelope className="text-lg inline ml-2" />اکنون تماس بگیرید</button>
                            <button className="text-neutral-500 sm:text-xs md:text-base w-fit"><MdOutlineShoppingCart className="text-lg inline" />سبد استعلام</button>
                        </div>
                        <div className="w-full h-full mt-3 grid grid-cols-3 gap-x-10 sm:col-span-2">
                            {i.products.length >= 0 &&
                                <>
                                    {i.products.map((product) => (
                                        <div className="group rounded-md transition-all duration-200  ease-in-out bg-white grid grid-rows-7 max-h-full md:h-5/6 lg:h-[90%]  hover:shadow-[0px_0px_12px_0px_rgba(0,0,0,0.25)]">
                                            <img className="row-span-4 h-full" src={product.image} alt="" />
                                            <div className="flex flex-col row-span-3 h-fit md:mt-0 sm:mt-2 items-center  md:group-hover:justify-around ">
                                                <p className="row-span-2 text-center text-sm">{product.name}</p>
                                                <button className="hidden md:group-hover:block bg-blue-600 text-white text-xs p-1 mx-auto rounded-md"><FaRegEnvelope className="inline" /> اکنون تماس بگیرید</button>
                                                <button className="text-sm hidden  md:group-hover:block"><MdOutlineShoppingCart className="inline text-neutral-600" />سبد استعلام</button>

                                            </div>

                                        </div>
                                    ))}
                                </>
                            }
                        </div>
                    </Link>
                ))}
                <Pagenate products={brands} />
            </div>
        </div>
    );
}