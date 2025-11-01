import Company from "./components/template/Company";
import CompanyPageMobile from "./components/template/CompanyPageMobile";

export default function CompanyPage({ data }) {

    return (
        <div>
            <Company data={data} />
            <CompanyPageMobile data={data} />
        </div>
    );
}