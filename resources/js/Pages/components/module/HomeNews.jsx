import { LazyLoadImage } from "react-lazy-load-image-component";

export default function HomeNews({ news }) {

    const newMap = news.slice(0, 3)

    return (
        <section className="lg:min-w-full lg:mx-auto mt-5">
            <div className="bg-white lg:min-w-full">
                <p className="pt-5 text-center text-2xl font-bold">نمایشگاه ما</p>
                <div className="flex justify-between px-12 pt-16 pb-11">
                    <div className="w-1/2">
                        <LazyLoadImage src={news[3].box_image_path} alt="" className="w-full h-full" />
                    </div>
                    <div className="w-24 text-center relative ">
                        <div className="w-[2px] bg-neutral-500 h-full mx-auto absolute left-1/2 z-10"></div>

                    </div>
                    <div className="w-1/2 flex flex-col justify-around">
                        {newMap.map((i) => (
                            <div key={i.id} className="min-w-1/2 flex flex-row items-center justify-cente my-10 w-full">
                                <div className="flex flex-row items-center">
                                    <LazyLoadImage className="w-2/5" src={i.box_image_path} alt="" />
                                    <p className="text-lg pr-3 font-bold lg:text-nowrap">{i.title}</p>

                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
}