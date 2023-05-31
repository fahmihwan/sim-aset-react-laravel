import DangerButton from "@/Components/DangerButton";
import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/inertia-react";

export default function Aset_dihapuskan(props) {
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Aset Dihapuskan
                </h2>
            }
        >
            <Head title="Aset saat ini" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                            kondisi
                                        </th>
                                        <th className="bg-neutral text-white">
                                            nama aset
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
                                    {props.detail_asets.data.map((data, i) => {
                                        return (
                                            <tr key={i}>
                                                <th>
                                                    {props.detail_asets.from +
                                                        i}
                                                </th>
                                                <td>{data.kode_detail_aset}</td>
                                                <td>{data.ruangan.ruangan}</td>
                                                <td>{data.kondisi}</td>
                                                <td>{data.aset.nama}</td>
                                                <td>
                                                    {
                                                        data.aset.kategori
                                                            .kategori
                                                    }
                                                </td>
                                                <td>
                                                    {
                                                        data.aset_masuk
                                                            .tanggal_masuk
                                                    }
                                                </td>
                                                <td>{data.updated_at}</td>
                                            </tr>
                                        );
                                    })}
                                </tbody>
                            </table>

                            <Pagination
                                totals={props.detail_asets.total}
                                className="mt-2"
                                links={props.detail_asets.links}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
