export default function CallCompany({ data }) {

    console.log(data)

    return (
        <div className="relative z-10 bg-zinc-100 ">
            <div className="w-full flex flex-row items-center gap-x-5 sm:p-7 p-3  ">
                {data.managment_profile_path && <img src={data.managment_profile_path} alt="" className=" rounded-full w-20 h-20" />}
                <div className="flex flex-col gap-y-4">

                    {data.managment_name && <p className="text-zinc-500 text-xs sm:text-sm ">{data.managment_name}</p>}
                    {data.managment_position && data.managment_name && <p className="text-zinc-500 text-xs sm:text-sm ">{data.managment_position}</p>}
                </div>
            </div>
            <div className="bg-white p-3">
                {data.managment_number && <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4 w-60 justify-between"> موبایل : <span className="text-black">{data.managment_number}</span></p>}
                {data.phone_number && <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4 w-60 justify-between">تلفن : <span className="text-black">{data.phone_number}</span></p>}
                {data.post_code && <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4 w-60 justify-between">کدپستی : <span className="text-black">{data.post_code}</span></p>}
                <p className="text-neutral-500  sm:text-sm text-xs flex flex-row gap-x-4 font-light mb-4 w-60 justify-between">آدرس : <span className="text-black">{`${data.province.name} / `}{data.city.name}</span></p>
            </div>
        </div>
    );
}