export default function CompantCategorySide() {
    return (
        <div className="w-full bg-white pl-10 pr-2 py-5">
            <h3 className="text-lg font-semibold text-nowrap">گروه های محصول</h3>
            <ul>
                {category.map((i, index) => (
                    <li key={index}>{i}</li>
                ))}
            </ul>
        </div>
    );
}