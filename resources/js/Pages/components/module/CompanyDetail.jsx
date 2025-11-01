import { HiOutlineEnvelope } from "react-icons/hi2";
import { LuMessageSquareText } from "react-icons/lu";

export default function CompanyDetail({ data }) {

    return (
        <div className="bg-white w-full mt-4 rounded-md overflow-hidden pb-6 lg:px-4 md:px-3">
            <div className="py-3 mb-3" >
                <img src={data.logo_path} alt="image" className="lg:w-11 lg:h-9 lg:min-h-9 md:w-10 md:min-h-8 md:h-8 inline" />
                <p className="inline font-semibold mr-2 lg:text-base md:text-sm">{data.name}</p>
            </div>
            <div className="flex flex-row gap-x-3 ">
                {data.managment_profile_path && <img className="rounded-full w-12 h-12" src={data.managment_profile_path} />}
                <div >
                    {data.managment_name && <p className="w-full md:text-sm lg:text-base lg:font-semibold ">خانم /اقا {data.managment_name}</p>}
                    {data.managment_position && data.managment_name && <span className="text-zinc-500 lg:text-sm md:text-xs">{data.managment_position}</span>}
                </div>
            </div>
            <div>
                <button className="mt-8 bg-blue-600 text-white flex flex-row items-center gap-x-3 mx-auto text-nowrap md:text-xs md:px-3 w-full md:py-2 lg:py-3  lg:text-lg rounded-full"> <HiOutlineEnvelope className="md:text-lg lg:text-2xl " />با تامین کننده تماس بگیرید </button>
                <button className="mt-2  text-black border-[1px] border-black flex flex-row items-center gap-x-3 justify-center md:text-sm md:py-2 w-full lg:mx-auto text-nowrap lg:py-3 lg:px-5 lg:text-lg  rounded-full"> <LuMessageSquareText className="md:text-lg lg:text-2xl " />چت کنید</button>
            </div>
        </div>
    );
}