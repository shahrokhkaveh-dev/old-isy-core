import { HiOutlineMenu } from "react-icons/hi";
import { IoSearch } from "react-icons/io5";

export default function NavbarCompany({ data }) {

    const list = [
        "درباره ما",
        "راه حل ها",
        "تماس با ما"
    ]


    return (
        <div>
            <div className=" flex-row justify-between py-10 lg:flex hidden items-center">
                <div className="px-2  flex flex-row justify-between w-full items-center">
                    <div className="flex flex-row gap-x-5 items-center">
                        <img src={data.logo_path} className="md:w-14 md:h-12 lg:w-14 lg:h-14" />
                        <div>
                            <p className="font-bold text-xl text-nowrap">{data.name}</p>

                        </div>
                    </div>
                    <div className=" flex flex-row  gap-x-10">
                        <div className="border-2 border-blue-900 w-[555px] h-10 flex flex-row">
                            <select className="border-l-[1px] border-neutral-300 px-1" name="category">
                                <option value="1">محصولات</option>
                                <option value="2">شرکت ها</option>
                            </select>
                            <input placeholder="لطفانام محصول مورد نظر خود را وارد کنید ..." className="w-full border-none px-4" type="text" />
                            <button className="bg-blue-900 text-white min-w-11  text-xl "><IoSearch className="mx-auto" /></button>
                        </div>
                        <button className="border-[1px] h-10 border-blue-800 text-lg text-blue-900 flex flex-row-reverse font-medium py-1 px-2 gap-x-2 text-nowrap">درخواست خود را ارسال کنید <img className="w-8 h-8" src="./icon/target.svg" alt="" /></button>
                    </div>
                </div>
            </div>
            <div className="w-full h-20 lg:hidden">banner</div>
            <div className="flex flex-row justify-between items-center md:px-5 lg:px-10">
                {/* <ul className=" flex flex-row gap-x-8 text-base items-center text-nowrap">
                    <li className="bg-neutral-300 px-7 lg:py-3 md:py-1  lg:text-lg lg:font-semibold">صفحه اصلی</li>
                    <li className="md:text-sm lg:text-base" ><HiOutlineMenu className="inline mx-1" />محصولات</li>
                    {list.map((i, index) => (
                        <li className="md:text-sm lg:text-base" key={index}>{i}</li>
                    ))}
                </ul> */}
                <div className="border-2 border-blue-900 w-80  h-8 flex flex-row lg:hidden">
                    <select className="border-l-[1px] border-neutral-300 text-xs px-[2px]" name="category">
                        <option value="1">در این سایت</option>
                        <option value="2">در کل صنعت یار</option>
                    </select>
                    <input placeholder="جست و جوی محصول" className="w-full border-none px-4 placeholder:text-xs" type="text" />
                    <button className="bg-blue-900 text-white min-w-11  text-xl "><IoSearch className="mx-auto" /></button>
                </div>
            </div>
        </div>
    );
}