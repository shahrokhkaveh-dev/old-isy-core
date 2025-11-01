import CardProduct from "../module/CardProduct";
import NavbarProduct from "../module/NavbarProduct";

export default function ProductPage() {

    return (
        <>
            <div className='bg-zinc-200 w-full h-72'>banner</div>
            <div>
                <NavbarProduct />
            </div>
            <div className='w-full h-full bg-white md:bg-slate-100 py-2 md:py-5 p-0  md:px-7 lg:px-12'>
                <h3 className='md:block hidden text-center text-lg font-semibold py-2 md:py-5'>دسته بندی یک</h3>
                <div className=' gap-2 md:gap-0 grid grid-cols-1 md:grid-cols-3  w-fit   flex-wrap'>
                    {product1.map((i) => (
                        <CardProduct item={i} />
                    ))}
                </div>
                <h3 className='text-center text-lg font-semibold py-5 md:block hidden'>دسته بندی دو</h3>
                <div className=' gap-2 md:gap-0 grid grid-cols-1 md:grid-cols-3  w-fit   flex-wrap'>
                    {product2.map((i) => (
                        <CardProduct item={i} />
                    ))}
                </div>
            </div>
        </>
    );
}