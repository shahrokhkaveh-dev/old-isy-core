export default function HomeProduct() {
    return (
        <section className="lg:container lg:mx-auto px-7 pt-5">
            <div className="bg-white flex">

                <div className="grid grid-cols-4 gap-y-10  gap-x-[100px]  px-[60px] pt-6 pb-[54px]">
                    <div className="text-center h-fit">
                        <div className="flex justify-center pb-3">
                            <h3 className="text-base text-[#1E1E1E] text-center">
                                لورم ایپسوم متن ساختگی
                            </h3>
                        </div>
                        <img src="../images/sss.svg" alt="" className=" object-cover mx-auto" />
                    </div>
                </div>

            </div>
        </section>
    );
}