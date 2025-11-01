import MobileAboutSanat from "./components/module/MobileAboutSanat";
import AboutSanatyar from "./components/template/AboutSanatyar";




export default function Welcome() {

    return (
        <div className='w-full h-screen '>
            <div>
                <AboutSanatyar />
                <MobileAboutSanat />
            </div>
        </div>
    )
}
