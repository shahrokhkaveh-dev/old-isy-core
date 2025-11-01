import { Link } from "@inertiajs/react";

export default function AtherProducts({ products }) {

    console.log(products)

    return (
        <>
            <div class="w-full lg:container mx-auto p-7">
                <div class="text-base font-bold pb-4">
                    <h1>محصولات مشابه را بیابید</h1>
                </div>
                <div class="flex flex-row flex-nowrap gap-x-7 overflow-x-auto p-2">
                    {products.map((i) => (
                        <Link href={`/new/peoduct/${i.slug}`} className="hover:shadow-[0_0_12px_0px_#00000040] overflow-hidden transition-all duration-300 p-2 w-36 h-24 min-h-48 min-w-36 sm:w-52 sm:h-72 sm:min-h-72 sm:min-w-52 rounded-lg flex flex-col ">
                            <div class="sm:w-full sm:h-full h-[90%] ">
                                <img class="" src={i.image} alt="" />
                            </div>
                            <div class="truncate text-xs text-[#515151]  pt-4 ">
                                <p className="sm:text-base text-sm font-semibold text-center truncate">{i.name}</p>
                                <p class="truncate mb-2 text-xs"> {i.description}  </p>

                            </div>
                            {/* <div class="flex text-xs justify-end pt-3 ">
                         <p>(تومان ایران) </p>
                         <p>50,000 - 1,000,000</p>
                     </div>
                     <div class="flex text-xs justify-end text-[#515151] ">
                         <p> 300 کیلو گرم </p>
                     </div> */}
                        </Link>
                    ))}

                </div>
            </div>
        </>
    );
}