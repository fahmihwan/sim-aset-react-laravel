import DangerButton from "@/Components/DangerButton";
import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/inertia-react";

export default function Show(props) {
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Detail Aset {props.ruangan.ruangan}
                </h2>
            }
        >
            <Head title="Aset saat ini" />

            <div className="pt-5 px-8 flex justify-end">
                <Link
                    href={route("informasi_aset.list_kelas")}
                    className="btn btn-sm bg-neutral "
                >
                    kembali
                </Link>
            </div>

            <div className="py-5">
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
                                            kode detail aset
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Aset
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Kondisi
                                        </th>
                                        <th className="bg-neutral text-white">
                                            ruangan
                                        </th>
                                        <th className="bg-neutral text-white">
                                            keterangan
                                        </th>
                                        <th className="bg-neutral text-white">
                                            tanggal masuk
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {props.detail_asets.map((data, i) => {
                                        return (
                                            <tr key={i}>
                                                <td>{i + 1}</td>
                                                <td>{data.kode_detail_aset}</td>
                                                <td>{data.aset.nama}</td>
                                                <td>{data.kondisi}</td>
                                                <td>{data.ruangan.ruangan}</td>
                                                <td>
                                                    {data.aset_masuk.keterangan}
                                                </td>
                                                <td>
                                                    {
                                                        data.aset_masuk
                                                            .tanggal_masuk
                                                    }
                                                </td>
                                            </tr>
                                        );
                                    })}
                                </tbody>
                            </table>

                            {/* <Pagination
                                totals={props.detail_asets.total}
                                className="mt-2"
                                links={props.detail_asets.links}
                            /> */}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
