import AtherProducts from "./components/module/AtherProducts";
import DetailSide from "./components/module/DetailSide";

export default function ProductDetail({ data }) {
    console.log(data)
    return (
        <div className="bg-white">
            <DetailSide data={data.product} />
            <AtherProducts products={data.otherProducts} />
        </div>
    );
}