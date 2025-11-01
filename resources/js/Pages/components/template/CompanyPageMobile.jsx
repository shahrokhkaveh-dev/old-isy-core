
import Explore from "../module/Explore";
import CompanyProducts from "../module/CompanyProducts";
import MobileNavbarCompany from "../module/MobileNavbarCompany";
import { useState } from "react";
import ProductsCompany from "../module/ProductsCompany";
import AboutCompanyPage from "../module/AboutCompanyPage";
import CallCompany from "../module/CallCompany";

export default function CompanyPageMobile({ data }) {

    const [Page, setPage] = useState(1)


    return (
        <div className="md:hidden w-full h-full bg-neutral-100 ">
            <MobileNavbarCompany data={data} Page={Page} setPage={setPage} />
            <div className="relative">
                <div className="w-full h-[90px] bg-gradient-to-b from-[#162B4A] to-[#F2F2F2] absolute top-0 z-0"></div>
                {Page == 1 && <CompanyProducts data={data.products} />}
                {Page == 2 && <ProductsCompany data={data.products} />}
                {Page == 3 && <AboutCompanyPage data={data} />}
                {Page == 4 && <CallCompany data={data.brand} />}
            </div>

        </div>
    );
}