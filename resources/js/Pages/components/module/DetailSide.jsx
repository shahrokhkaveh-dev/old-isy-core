import { Link } from "@inertiajs/react";

export default function DetailSide({ data }) {

    console.log(data)


    return (
        <div className="grid md:grid-cols-2 gap-x-24">
            <div className="w-full h-full">
                <img className="w-full md:h-full md:min-h-full sm:min-h-[576px] min-h-[320px] h-[320px] sm:h-567px" src={data.image} alt="" />
            </div>
            <div>
                <h3 class="text-base font-bold py-5 w-full border-b-[1px] "> {data.name}</h3>
                <div class="py-4">
                    <div className="border-b-[1px] pb-5">
                        <h3 class="text-base font-bold">
                            جزئیات محصول
                        </h3>
                        <ul class=" sm:w-full  md:w-3/4 text-xs py-7 gap-2 ">
                            {data.attributes.map((i) => (
                                <li className="md:w-full w-fit gap-x-16  sm:w-2/6 text-nowrap  flex flex-row justify-between">{i.name} : <span>{i.value}</span></li>
                            ))}
                        </ul>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-full text-xs">
                            <svg class="inline ml-2" xmlns="http://www.w3.org/2000/svg" width="19" height="20"
                                viewBox="0 0 19 20" fill="none">
                                <path
                                    d="M2.77083 4.49995L8.44273 10.5859C8.48084 10.6268 8.52154 10.6657 8.56949 10.6945C8.85085 10.8631 9.23844 10.8474 9.5 10.6473L16.2292 4.49995M3.16667 15.1904H15.8333C16.2706 15.1904 16.625 14.8359 16.625 14.3985V4.89589C16.625 4.45854 16.2706 4.104 15.8333 4.104H3.16667C2.72944 4.104 2.375 4.45854 2.375 4.89589V14.3985C2.375 14.8359 2.72944 15.1904 3.16667 15.1904Z"
                                    stroke="white" stroke-linecap="round" />
                            </svg>
                            <span>با تامین کنند تماس بگیرید</span>
                        </button>
                        {/* <div class="text-xs pt-3">
                            <span>هنوز در حال تصمیم گیری؟ نمونه هایی با قیمت 0 تومان ایران / قطعه دریافت کنید
                                درخواست نمونه</span>
                        </div> */}
                    </div>
                </div>
                {/* <div className='flex flex-col w-full px-3'>
                    <p className='text-base md:hidden pb-5'>نمونه خدمات</p>
                    <Link className='border-[1px] border-black w-full rounded-full  text-center'>نمونه بگیرید</Link>
                </div> */}
                <div className="py-3">
                    <div className='flex flex-col gap-x-8 py-3 border-b-[1px] bg-gradient-to-l from-slate-200 to-[#fdfdfe] relative'>
                        <img className="w-[187px] h-[79px] absolute left-0 top-0 z-10" src="/icon/CBG.png" alt="" />
                        <div className='flex flex-row items-center gap-x-2 z-20'>
                            <div className='w-32'>
                                <img className='w-full h-full' src={data.brand.logo_path} alt="fds" />
                            </div>
                            <p className='sm:text-base text-2xl '>{data.brand.name}</p>
                        </div>
                        {/* <p className='text-sm py-5'>مساحت کارخانه  :    <span className='text-xs font-light'>میانگین زمان پاسخ گویی</span></p> */}
                        {/* <div className='md:hidden w-full grid grid-cols-2 sm:px-10 sm:gap-x-4 px-4 gap-x-5'>
                            <Link href={`/new/company/${data.brand.slug}`} className='border-[1px] text-center rounded-full border-black text-sm sm:text-base'>جزییات شرکت</Link>
                            <Link className='border-[1px] rounded-full text-center border-black text-sm sm:text-base'>محصولات بیشتر</Link>
                        </div> */}

                    </div>
                </div>
            </div>
        </div>
    );
}