export default function HomeOption() {

    const option = [
        { title: "نمایشگاه هوشمند", image: "homebanner4.png" },
        { title: "خدمات بازرگانی ایمن شد", image: "homebanner2.png" },
        { title: "کارخانه پیشرو", image: 'homebanner1.png' },
        { title: "تامین کننده انتخاب شده است", image: "homebanner3.png" }
    ]
    return (
        <div className="w-full grid grid-cols-4 md:gap-x-2 lg:gap-x-5  mt-5">
            {option.map((i, index) => (
                <div key={index} className="bg-neutral-200 lg:block md:flex flex-col justify-between">
                    <p>{i.title}</p>
                    <div className="flex justify-end">
                        <img className="fle" src={`./banner/${i.image}`} alt="" />
                    </div>
                </div>
            ))}
        </div>
    );
}