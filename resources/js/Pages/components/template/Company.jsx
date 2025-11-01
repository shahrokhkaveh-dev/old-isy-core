import { HiOutlineMenu } from "react-icons/hi";
import { LuMessageSquareText } from "react-icons/lu";
import ProductCompany from '../module/ProductCompany'
import { HiOutlineEnvelope } from "react-icons/hi2";
import { IoSearch } from "react-icons/io5";
import ReqCompany from "../module/ReqCompany";
import CategoryCompany from "../module/CategoryCompany";
import CompanyDetail from "../module/CompanyDetail";
import NavbarCompany from "../module/NavbarCompany";
import CompantCategorySide from "../module/CompantCategorySide";
import CompanyCategorySide from "../module/CompanyCategorySide";
import CompanyAddres from "../module/CompanyAddres";

export default function Company({ data }) {

    return (
        <div className="hidden md:block">
            {/* <NavbarCompany data={data.brand} /> */}
            <div className="px-10 py-5">
                {/* <div className="pb-5">
                    <div className="bg-zinc-300 md:h-52 lg:h-[300px]">banner</div>
                </div> */}
                <div>
                    <CompanyAddres data={data.brand} />
                </div>
                <div className=" flex flex-row ">
                    <div className="lg:min-w-80 w-56  ml-5">
                        {/* <CompanyCategorySide /> */}
                        <CompanyDetail data={data.brand} />
                    </div>
                    <CategoryCompany data={data.products} />
                </div>
                <ReqCompany data={data.brand} />
            </div>
        </div>
    );
}