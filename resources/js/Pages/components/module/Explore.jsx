import CardProduct from "./CardProduct";

export default function Explore() {

    const product1 = [
        { desc: "kljsdfjklsfklasfhsakjfhsakjhfncsakdljfhksdfcnsfljkhsafnc.ksajfh", price: "تومان ایران", x: '396', gar: '12' },
        { desc: "kljsdfjklsfklasfhsakjfhsakjhfncsakdljfhksdfcnsfljkhsafnc.ksajfh", price: "تومان ایران", x: '396', gar: '12' },
        { desc: "kljsdfjklsfklasfhsakjfhsakjhfncsakdljfhksdfcnsfljkhsafdsfdsfdsfdsfdsfsdfsfsfdsfnc.ksajfh", price: "تومان ایران", x: '396', gar: '12' },
        { desc: "kljsdfjklsfklasfhsakjfhsakjhfncsakdljfhksdfcnsfljkhsafnc.ksajfh", price: "تومان ایران", x: '396', gar: '12' },
        { desc: "kljsdfjklsfklasfhsakjfhsakjhfncsakdljfhksdfcnsfljkhsafnc.ksajfh", price: "تومان ایران", x: '396', gar: '12' },
        { desc: "kljsdfjklsfklasfhsakjfhsakjhfncsakdljfhksdfcnsfljkhsafdsfdsfdsfdsfdsfsdfsfsfdsfncksajfh", price: "تومان ایران", x: '396', gar: '12' },
        { desc: "منتابنتمازئسمهابهثعلبدذسمعلادسشکشنمغاضصثی87ض234تابسشذزشلاب28734غحصثمتنالشصثنعقل98723", price: "تومان ایران", x: '396', gar: '12' },
        { desc: "منتابنتمازئسمهابهثعلبدذسمعلادسشکشنمغاضصثی87ض234تابسشذزشلاب28734غحصثمتنالشصثنعقل98723", price: "تومان ایران", x: '396', gar: '12' },
    ]
    return (
        <div className="px-2">
            <h2 className="m-5 text-lg font-bold" >محصولات داغ</h2>
            <div className="sm:hidden">
                {product1.map((i) => (
                    <CardProduct item={i} />
                ))}
            </div>
            <div className="grid grid-cols-2 gap-2">
                {product1.map((item, index) => (
                    <div key={index} className='flex flex-row sm:grid sm:grid-rows-2 sm:grid-cols-1 py-2 px-3 sm:px-0 sm:py-0 sm:border-[1px] border-neutral-500 w-full bg-neutral-100 sm:bg-white'>
                        <div className='md:row-span-2 min-w-[120px] md:w-full bg-zinc-200'>image</div>
                        <div className='md:col-span-1 md:row-span-1 px-2 py-4 flex flex-col w-full overflow-hidden'>
                            <p className='truncate  w-full text-neutral-600 my-2 sm:text-sm md:text-sm lg:text-base text-xs '>{item.desc}</p>
                            <p className='md:text-left mt-2 lg:text-base md:text-sm text-xs sm:text-sm'>{`(${item.price})`} / قطعه <span className='text-blue-900'>{item.x}</span></p>
                            <p className='text-neutral-600 text-left mt-3 lg:text-sm md:text-xs md:block hidden'>گارانتی : {item.gar} ماه</p>
                        </div>
                    </div>
                ))}
            </div>

        </div>
    );
}