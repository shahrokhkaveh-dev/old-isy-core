export default function ReqCompany({ data }) {

    console.log(data)
    return (
        <div className="bg-white mt-8 flex flex-col gap-y-3 py-8 px-5 ">
            <div className="flex flex-row items-center gap-x-2">
                <label className="text-nowrap lg:text-base md:text-sm" htmlFor="message" >از طرف : </label>
                <input type="text" name="message" id="message" className="border-[1px] border-gray-200 w-full placeholder:text-neutral-500 text-sm py-3 px-5 lg:h-auto md:h-11" placeholder="آدرس ایمیل خود را وارد کنید" />
            </div>
            <div className="flex flex-row gap-x-2 items-center">
                <p className="text-sm">به : </p>
                {data.managment_profile_path && <img src={data.managment_profile_path} className="w-12 h-12 bg-zinc-200 rounded-md" alt="prodfile" />}
                <p className="lg:text-base md:text-sm">{data.managment_name}</p>
            </div>
            <div className="flex flex-col font-light">
                <textarea placeholder="از شما خواهشمندیم اطلاعات دقیقی از نیاز هاتون برای ما بفرستید " className="border-[1px] border-gray-200 w-full md:h-36 lg:h-56 py-4 px-5 placeholder:text-sm" name="" id="" />
                <span className="text-neutral-500 lg:text-sm md:text-xs  mt-2">بین 20 تا 4000 کاراکتر وارد کنید.</span>
                <span className="text-blue-600 md:text-xs lg:text-sm">محتوای درخواست شما باید بین 20 تا 4000 کاراکتر باشد</span>
            </div>
            <div className="flex flex-row gap-x-5 items-center ">
                <button className="text-white md:text-sm lg:text-base bg-blue-700 p-2 rounded-md">متن درخواست خود را ارسال کنید</button>
                <p className="text-neutral-500 lg:text-base md:text-sm">این چیزی نیست که به دنبال آن هستید ؟  </p>
                <img src="https://sanatyariran.com/icon/target.svg" className="w-6 h-6" alt="" />
                <p className="text-blue-600 text-sm">اکنون یک درخواست منبع ارسال کنید</p>
            </div>

        </div>
    );
}