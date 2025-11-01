import { Link } from "@inertiajs/react";
import { useEffect, useRef, useState } from "react";
import { LazyLoadImage } from "react-lazy-load-image-component";

export default function Expelor() {

    const [data, setdata] = useState([])
    const [loading, setLoading] = useState(false);

    const fetchExplor = async () => {
        if (loading) return;

        setLoading(true);

        const res = await fetch('http://127.0.0.1:8000/api/explore')
            .then((res) => res.json())
            .then((newData) => {
                setdata((prev) => [...prev, ...newData.products]);
            })
            .catch((err) => console.log(err))
            .finally(() => setLoading(false));
    };


    useEffect(() => {

        fetchExplor();

        const handleScroll = () => {

            if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
                fetchExplor();
            }
        };

        window.addEventListener('scroll', handleScroll);

        return () => {
            window.removeEventListener('scroll', handleScroll);
        };
    }, []);

    return (
        <section className="md:hidden" >
            <h3 className="my-4">محصولات پر طرفدار</h3>
            <div className="grid grid-cols-2 px-2 gap-2  ">

                {data.length && data.map((i) => (
                    <Link href={`/new/product/${i.slug}`} key={i.id} className='flex flex-col  sm:grid-cols-1  sm:px-0 sm:py-0 sm:border-[1px]  w-full bg-white '>
                        <LazyLoadImage className='md:row-span-2 w-full sm:h-52 sm:min-h-52 min-h-[145px] h-[145px] md:w-full bg-zinc-200' src={i.image} />
                        <div className='md:col-span-1 md:row-span-1 px-2 py-4 flex flex-col w-full overflow-hidden'>
                            <p className='text-wrap text-center  w-full text-neutral-600 my-2 sm:text-sm md:text-sm lg:text-base text-xs '>{i.name}</p>
                            {/* <p className='md:text-left mt-2 lg:text-base md:text-sm text-xs sm:text-sm'>{`(${item.price})`} / قطعه <span className='text-blue-900'>{item.x}</span></p>
                        <p className='text-neutral-600 text-left mt-3 lg:text-sm md:text-xs md:block hidden'>گارانتی : {item.gar} ماه</p> */}
                        </div>
                    </Link>
                ))}
            </div>
        </section>
    );
}