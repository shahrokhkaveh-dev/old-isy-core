import CardProduct from "./components/module/CardProduct";
import MobileCategory from "./components/module/MobileCategory";
import MobileCategoryNav from "./components/module/MobileCategoryNav";
import SidebarHome from "./components/module/SidebarHome";
import HomePage from "./components/template/HomePage";
import HomePageMbile from "./components/template/HomePageMbile";


export default function Home({ data, auth }) {




    return (
        <>
            <SidebarHome auth={auth} category={data.section1.categories} />
            <MobileCategoryNav data={data.section1.categories} />
            <HomePage data={data} />
            <HomePageMbile data={data} />

        </>
    );
}
