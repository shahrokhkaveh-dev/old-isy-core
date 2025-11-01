import CardProduct from "./CardProduct";

export default function ProductsCompany({ data }) {




    return (
        <div className="relative z-10 flex flex-col gap-5 py-5 bg-white">
            {data.map((i) => (
                <CardProduct item={i} />
            ))}
        </div>
    );
}