import { LazyLoadImage } from "react-lazy-load-image-component";
import CategoryNav from "./CategoryNav";
import ProductHomeCard from "./ProductHomeCard";

export default function HomeCategoryProducts({ data }) {

    return (
        <div className="flex flex-col " >
            {Object.keys(data).map((i, index) => (
                <div key={index} className="flex flex-row  my-3 lg:gap-x-24 md:gap-x-12 bg-white">
                    <div className="w-96">
                        <LazyLoadImage src={data[i].image} className=" w-full min-w-full h-full min-h-full" alt="" />
                    </div>
                    <div className=" w-full h-full grid grid-cols-4 gap-1 px-4 py-5">
                        {data[i].products.map((i) => (
                            <ProductHomeCard item={i} />
                        ))}
                    </div>
                </div>
            ))}


        </div>
    );
}
