import Footer from "./Footer";
import Header from "./Header";

export default function Layot({ children }) {
    return (
        <>
            <Header />
            {children}
            <Footer />
        </>
    );
}