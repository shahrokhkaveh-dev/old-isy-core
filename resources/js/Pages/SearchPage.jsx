import Catogiry from "./components/module/Category";
import CategorySide from "./components/module/CategorySide";
import MobileCategory from "./components/module/MobileCategory";
import NavbarSearch from "./components/module/NavbarSearch";
import Product from "./components/template/Product";


export default function SearchPage() {
    return (
        <>
            <div className='w-full h-f flex flex-col md:px-7 '>
                <p className='text-gray-600 text-sm font-normal text-right my-8 md:block hidden'>نتیجه برای <span className=' mr-2.5 text-black text-2xl font-bold'>کشاورزی و غذا</span></p>
                <NavbarSearch />
                <hr className="md:block hidden" />
                <div className='md:hidden bg-neutral-100 px-2 py-3'>
                    <p className='text-xs'><span className='text-blue-600 font-semibold' >200</span>محصولات <span className='font-semibold'>کشاورزی</span></p>
                </div>
                <div className='w-full h-full'>
                    <div>
                        <div className='md:grid md:grid-cols-5 md:gap-6 w-full md:mt-5 md:bg-white  h-full bg-gray-100'>
                            <CategorySide />
                            <div className='w-full col-span-4'>
                                {/* <Catogiry /> */}
                                <Product />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <MobileCategory />
        </>
    );
}