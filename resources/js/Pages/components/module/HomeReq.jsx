export default function HomeReq() {
    return (
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
    );
}