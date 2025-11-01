export default function CompanyCategorySide() {

    const category = [
        "castegory", "castegory", "castegory", "castegory", "castegory",
    ]

    return (
        <div className="w-full bg-white pl-10 pr-2 md:py-4 lg:py-5">
            <h3 className="lg:text-lg text-base font-semibold text-nowrap mb-5">گروه های محصول</h3>
            <ul>
                {category.map((i, index) => (
                    <li className="text-neutral-500" key={index}>{i}</li>
                ))}
            </ul>
        </div>
    );
}