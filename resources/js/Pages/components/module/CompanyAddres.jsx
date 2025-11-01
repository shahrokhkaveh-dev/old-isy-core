export default function CompanyAddres({ data }) {

    return (
        <div className="bg-white grid grid-cols-3 mb-8 gap-x-6">
            <div className="col-span-1 w-full h-full p-6">
                <img className="w-full h-full " src={data.logo_path} alt="imagecompany" />
            </div>
            <div className="col-span-2">
                <ul>
                    {data.category && <li className="rowcompany"><span className="w-44"> نوع صنعت : </span>{data.category.name}<span></span></li>}
                    {data.phone_number && <li className="rowcompany"><span className="w-44"> شماره تماس : </span>{data.phone_number}<span></span></li>}
                    {data.url && <li className="rowcompany"><span className="w-44"> وب سایت : </span>{data.url}<span></span></li>}
                    <li className="rowcompany"><span className="w-44">  استان / شهر : </span>{data.province.name} / {data.city.name}<span></span></li>
                    {data.address && < li className="rowcompany"><span className="w-44"> آدرس : </span>{data.address}<span></span></li>}
                </ul>
            </div>

        </div >
    );
}