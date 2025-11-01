import { useEffect, useState } from "react";
import ProductCompany from "./ProductCompany";

export default function CategoryCompany({ data }) {






    return (
        <div className="bg-white px-5 w-full">
            <h3 className="lg:my-8 md:my-5 md:text-base lg:text-xl font-bold">لیست محصولات</h3>
            <div className=" grid grid-cols-3 gap-y-3 gap-x-5 lg:max-h-[685px] md:max-h-[640px] overflow-y-auto" >
                {!data.length <= 0 ?
                    <>
                        {data.map((item, index) => (
                            <ProductCompany key={index} item={item} />
                        ))}
                    </> :
                    <h3 className="text-lg text-blue-600">برای این شرکت محصولی یافت نشد</h3>

                }
            </div>
        </div>
    );
}