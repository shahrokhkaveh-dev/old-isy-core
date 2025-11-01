export default function CategoryNav({ categories }) {


    const chunkedCategories = categories.reduce((acc, _, i) => {
        if (i % 4 === 0) acc.push(categories.slice(i, i + 4));
        return acc;
    }, []);

    return (
        <div className=" mt-4 rounded  flex flex-row justify-around">
            {chunkedCategories.map((group, index) => (
                <ul key={index} className="mb-4  pb-2  lg:text-base md:text-xs">
                    {group.map((category, i) => (
                        <li key={i} className="  rounded my-1">
                            <a href={`/new/products?category=${category.id}`}>{category.name}</a>
                        </li>
                    ))}
                </ul>
            ))}
        </div>
    );
}