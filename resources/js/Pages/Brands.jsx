import { usePage } from "@inertiajs/react";
import CategorySide from "./components/module/CategorySide";
import BrandsPage from "./components/template/BrandsPage";
import MobileCategory from "./components/module/MobileCategory";
import NavbarSearch from "./components/module/NavbarSearch";
export default function Home({ data }) {
    const { auth } = usePage().props;

    return (
        <div className=" flex flex-col  w-full h-full bg-white px-7">
            {data.resultFor && <p className='text-gray-600 text-sm font-normal text-right my-8 md:block hidden col-span-full '>نتیجه برای <span className=' mr-2.5 text-black text-2xl font-bold'>{data.resultFor}</span></p>}
            <NavbarSearch />
            <div className="grid sm:grid-cols-5  w-full h-full md:mt-5">
                <MobileCategory filters={data.filters} />
                <CategorySide category={data.filters} />
                <BrandsPage brands={data.brands} />
            </div>
        </div>
    );
}
