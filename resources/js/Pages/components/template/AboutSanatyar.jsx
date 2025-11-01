export default function AboutSanatyar() {

    const x = [
        'لورم ایپسوم متن ساختگی ', 'لورم ایپسوم متن ساختگی ', 'لورم ایپسوم متن ساختگی ', 'لورم ایپسوم متن ساختگی ', 'لورم ایپسوم متن ساختگی ', 'لورم ایپسوم متن ساختگی '
    ]

    return (
        <div className="bg-gray-100 pb-20 md:block hidden">
            <div className="w-full hidden lg:flex h-[700px] bg-[url('./banner/banner2.png')] bg-cover bg-center bg-no-repeat  flex-col justify-between items-center py-16" style={{ borderRadius: "25% 25% 20% 20% / 0% 0% 14% 14%" }} >
                <div className="text-white px-60">
                    <h3 className="text-xl font-semibold text-center mb-16">درباره ما</h3>
                    <p className="font-light">  درباره ما
                        به عنوان یک پلت فرم خدمات جامع برای تجارت در سطح کشوری و بین المللی ، متعهد به بهره برداری از فرصت های تجاری برای تامین کنندگان و خریداران خارجی و ارائه خدمات یک مرحله ای برای ارتقای تجارت بین المللی بین دو طرف است.

                        در چند سال گذشته، صنعت یار ایران به یکی از گسترده ترین و قابل اعتمادترین آدرس های وب برای تجارت بین المللی
                        تبدیل شده است</p>
                </div>
                <div className=" flex flex-row gap-x-40">
                    <p className="flex flex-col items-center" >
                        <span className="text-white text-2xl">6500 +</span>
                        <span className="font-light text-center text-white text-sm">دسته بندی ها</span>
                    </p>
                    <p className="flex flex-col items-center" >
                        <span className="text-white text-2xl">6000,000,000 +</span>
                        <span className="font-light text-center text-white text-sm">اعضای تامین کننده ثبت شده</span>
                    </p>
                    <p className="flex flex-col items-center" >
                        <span className="text-white text-2xl">20,000,000 +</span>
                        <span className="font-light text-center text-white text-sm">اعضای خریدار ثبت نام شده </span>
                    </p>
                    <p className="flex flex-col items-center" >
                        <span className="text-white text-2xl">1,000,000 +</span>
                        <span className="font-light text-center text-white text-sm">تعداد محصول ثبت شده</span>
                    </p>
                </div>
            </div>
            <div className="w-full h-[700px] bg-[url('./banner/banner2.png')] bg-cover bg-center bg-no-repeat flex flex-col justify-between items-center py-16" style={{ borderRadius: "218% 25% 20% 20% / 0% 0% 14% 14%" }} >
                <div className="text-white px-60">
                    <h3 className="text-xl font-semibold text-center mb-16">درباره ما</h3>
                    <p className="font-light">  درباره ما
                        به عنوان یک پلت فرم خدمات جامع برای تجارت در سطح کشوری و بین المللی ، متعهد به بهره برداری از فرصت های تجاری برای تامین کنندگان و خریداران خارجی و ارائه خدمات یک مرحله ای برای ارتقای تجارت بین المللی بین دو طرف است.

                        در چند سال گذشته، صنعت یار ایران به یکی از گسترده ترین و قابل اعتمادترین آدرس های وب برای تجارت بین المللی
                        تبدیل شده است</p>
                </div>
                <div className=" flex flex-row gap-x-40">
                    <p className="flex flex-col items-center" >
                        <span className="text-white text-2xl">6500 +</span>
                        <span className="font-light text-center text-white text-sm">دسته بندی ها</span>
                    </p>
                    <p className="flex flex-col items-center" >
                        <span className="text-white text-2xl">6000,000,000 +</span>
                        <span className="font-light text-center text-white text-sm">اعضای تامین کننده ثبت شده</span>
                    </p>
                    <p className="flex flex-col items-center" >
                        <span className="text-white text-2xl">20,000,000 +</span>
                        <span className="font-light text-center text-white text-sm">اعضای خریدار ثبت نام شده </span>
                    </p>
                    <p className="flex flex-col items-center" >
                        <span className="text-white text-2xl">1,000,000 +</span>
                        <span className="font-light text-center text-white text-sm">تعداد محصول ثبت شده</span>
                    </p>
                </div>
            </div>
            <div className="py-8 ">
                <h3 className="text-center text-xl font-semibold mb-10">خدمات ما</h3>
                <div className="flex flex-row md:gap-x-8 lg:justify-between  overflow-x-auto py-2">
                    {x.map((i, index) => (
                        <div className="p-2 bg-white rounded-md " key={index}>
                            <img src="" alt="image" className="min-w-44 h-44 bg-zinc-200" />
                            <p className="text-neutral-500 text-sm font-light text-center mt-4">{i}</p>
                        </div>
                    ))}
                </div>
            </div>

            <div className="h-[490px] overflow-hidden flex flex-row-reverse relative mb-10">
                <div className="w-full h-full overflow-hidden bg-red-400" >
                    <img src="" alt="iamge" className="w-full object-cover h-full" />
                </div>
                <div style={{ clipPath: 'polygon(54.8% 0%, 100% 0%, 100% 100%, 0% 100%)' }} className="bg-white w-3/4 right-0 h-full absolute p-20">
                    <div className="w-3/5">
                        <h3 className="lg:text-xl md:text-lg font-semibold mb-11">تامین کنندگان قابل اعتماد صنعت یار ایران</h3>
                        <p className="text-base text-wrap ">
                            ایده اعتمادسازی و کاهش ریسک‌ها در خریدهای تجاری، از اهمیت بالایی برخوردار است.

                            در دنیای امروز، وجود تامین‌کنندگان قابل اعتماد و معتبر، به یک نیاز اساسی برای خریداران
                            جهانی تبدیل شده است.

                            یکی از روش‌های موثر در تأیید اعتبار تامین‌کنندگان، همکاری با شرکت‌های بازرسی برجسته
                            کشور است.

                            این شرکت‌ها با انجام بازرسی‌های دقیق و حرفه‌ای، اطمینان حاصل می‌کنند که تامین‌کنندگان
                            استانداردهایکیفی و ایمنی لازم را رعایت می‌کنند.</p>
                    </div>
                </div>
            </div>
            <div className="h-[490px] overflow-hidden flex flex-row-reverse relative mb-10">
                <div className="w-full h-full overflow-hidden bg-red-400" >
                    <img src="" alt="iamge" className="w-full object-cover h-full" />
                </div>
                <div style={{ clipPath: 'polygon(0% 0%, 54.8% 0%, 100% 100%, 0% 100%)' }} className="bg-white w-3/4 left-0 h-full overflow-hidden absolute p-20 flex flex-col items-end">
                    <div className='w-3/5'>
                        <h3 className="lg:text-xl md:text-lg font-semibold mb-11">به راحتی با خیال راحت تجارت کنید</h3>
                        <p className="text-base text-wrap ">
                            در دنیای تجارت امروز، کاهش ریسک‌ها و ایجاد اعتماد از اهمیت بالایی برخوردار است.

                            با انتخاب تأمین‌کنندگان تأیید شده، می‌توانید از کیفیت و ایمنی محصولات و خدمات مطمئن باشید.

                            دسترسی آنلاین و رایگان به گزارش‌های حسابرسی این تأمین‌کنندگان، شفافیت بیشتری فراهم می‌کند و به شما امکان می‌دهد با اطمینان خاطر، به راحتی تجارت کنید.
                        </p>
                    </div>
                </div>
            </div>
            <div className="bg-[url('./banner/call.png')] min-h-72 bg-no-repeat bg-cover w-full flex flex-row justify-between px-16 py-7">
                <div >
                    <h3 className="text-xl font-semibold mb-12">منابع یابی آسان</h3>
                    <p className="text-wrap w-2/3 text-stone-500">
                        راهی آسان برای ارسال درخواست های منبع خود و دریافت قیمت.

                        یک درخواست، چند نقل قول


                        تطبیق تامین کنندگان تایید شده

                        مقایسه مظنه و درخواست نمونه
                    </p>
                </div>
                <div className="lg:min-w-[580px] md:min-w-[371px]  bg-white p-4 flex flex-col gap-y-4 ">
                    <h3 className="lg:text-xl md:text-lg font-semibold">میخواهید نقل و قول دریافت کنید ؟</h3>
                    <input placeholder="نام محصول و کلمات کلیدی" type="text" className="min-h-10 px-2 w-full border-[1px] border-zinc-300" />
                    <textarea placeholder="توضیحات محصول" name="" className="border-[1px] px-2 py-3 border-zinc-300 w-full overflow-auto min-h-20 outline-none" id=""></textarea>
                    <div className="grid grid-cols-2 w-fit gap-x-6">
                        <input placeholder="مقدار خرید" className="border-[1px] border-zinc-300 py-3 px-2 h-full" type="text" />
                        <input className="border-[1px] border-zinc-300 py-3 px-2 h-full" type="text" placeholder="قطعه های" name="" id="" />
                    </div>
                    <button className="text-white bg-blue-600 px-8 py-2 rounded-md font-light w-fit lg:text-base md:text-sm">متن درخواست خود را ارسال کنید</button>
                </div>
            </div>
            <div className="grid grid-cols-4 mt-10  ">
                <img src="" alt="image" className="min-h-full w-full bg-red-500 col-span-1" />
                <div className="bg-white w-full h-fit py-10 px-36 col-span-3">
                    <h3 className="text-xl font-bold">داستان موفقیت</h3>
                    <p className="text-base mt-10">در دنیای تجارت امروز، کاهش ریسک‌ها و ایجاد اعتماد از اهمیت بالایی برخوردار است.

                        با انتخاب تأمین‌کنندگان تأیید شده، می‌توانید از کیفیت و ایمنی محصولات و خدمات مطمئن باشید.

                        دسترسی آنلاین و رایگان به گزارش‌های حسابرسی این تأمین‌کنندگان، شفافیت بیشتری فراهم می‌کند و به شما امکان می‌دهد با اطمینان خاطر، به راحتی تجارت کنید.</p>
                </div>
            </div>

        </div>
    );
}