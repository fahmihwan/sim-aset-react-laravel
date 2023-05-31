import DangerButton from "@/Components/DangerButton";
import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/inertia-react";
import axios from "axios";
import { useEffect, useState } from "react";


export default function Index(props) {
   const[search, setSerach]= useState('');
   const[data, setDatas]= useState([]);


    useEffect(()=>{

            axios.post('/get_search_aset_saatini/',{
                search: search,
            })
            .then((res) => {
                setDatas(res.data)
            });
        
    },[search])

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Aset Saat Ini
                </h2>
            }
        >
            <Head title="Aset saat ini" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <input
                type="text"
                value={search}
                className={
                    `border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mb-3` }
                placeholder="cari kode / aset"

                onChange={(e) => setSerach(e.target.value)}
            />

                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="overflow-x-auto">
                            <table className="table w-full">
                                <thead>
                                    <tr>
                                        <th className="bg-neutral text-white">
                                            No 
                                        </th>
                                        <th className="bg-neutral text-white">
                                            kode aset
                                        </th>
                                        <th className="bg-neutral text-white">
                                            ruangan
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Nama aset
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Kondisi
                                        </th>
                                        <th className="bg-neutral text-white">
                                            kategori
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Tanggal Masuk
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Tanggal berubah
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {data?.data?.map((d, i) => {

                                        // console.log(d);
                                        return (
                                            <tr key={i}>
                                                <th>
                                                    {data.from +
                                                        i}
                                                </th>
                                                <td>{d.kode_detail_aset}</td>
                                                <td>{d.ruangan.ruangan}</td>
                                                <td>{d.aset.nama}</td>
                                                <td>{d.kondisi}</td>
                                                <td>
                                                    {
                                                        d.aset.kategori
                                                            .kategori
                                                    }
                                                </td>
                                                <td>
                                                    {
                                                        d.aset_masuk
                                                            .tanggal_masuk
                                                    }
                                                </td>
                                                <td>{d.updated_at}</td>
                                            </tr>
                                        );
                                    })}
                                </tbody>
                            </table>

                            {/* <Pagination
                                totals={data?.total}
                                className="mt-2"
                                links={data?.links}
                            /> */}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
