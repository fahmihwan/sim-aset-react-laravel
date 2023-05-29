import DangerButton from "@/Components/DangerButton";
import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage } from "@inertiajs/inertia-react";
import { Link } from "@inertiajs/inertia-react";

const Index = (props) => {
    const { errors, auth } = usePage().props;

    const handleDelete = (id) => {
        confirm("apakah anda yakin ingin menghapus?") &&
            Inertia.delete(`/aset_pemeliharaan/${id}`);
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Aset Pemeliharaan
                </h2>
            }
        >
            <Head title="Aset Masuk" />

            <div className="pt-5 px-8  flex justify-end">
                {auth.user.hak_akses == "sarpras" && (
                    <Link
                        href={route("aset_pemeliharaan.create")}
                        className="btn btn-sm bg-neutral "
                    >
                        Tambah Data
                    </Link>
                )}
            </div>

            <div className="py-5">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-10">
                        <div className="overflow-x-auto">
                            <table className="table w-full">
                                <thead>
                                    <tr>
                                        <th className="bg-neutral text-white">
                                            No
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Tanggal Pemeliharaan
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Kode
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Verfikasi
                                        </th>
                                        <th className="bg-neutral text-white">
                                            keterangan
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {props?.aset_pemeliharaan?.data?.map(
                                        (data, i) => {
                                            console.log(data);
                                            return (
                                                <tr key={i}>
                                                    <th>
                                                        {i +
                                                            props
                                                                .aset_pemeliharaan
                                                                .from}
                                                    </th>
                                                    <td>
                                                        {
                                                            data.tanggal_pemeliharaan
                                                        }
                                                    </td>
                                                    <td>
                                                        {data.kode_pemeliharaan}
                                                    </td>
                                                    <td>
                                                        {data.verifikasi ? (
                                                            <span className="text-success font-bold">
                                                                sudah
                                                            </span>
                                                        ) : (
                                                            <span className="text-error font-bold">
                                                                belum
                                                            </span>
                                                        )}
                                                    </td>
                                                    <td>{data.keterangan}</td>
                                                    <td>
                                                        <Link
                                                            href={`/aset_pemeliharaan/${data.id}`}
                                                            className="btn btn-sm btn-info mr-3 text-white "
                                                        >
                                                            <i className="fa-regular fa-folder-open"></i>
                                                        </Link>
                                                        <DangerButton
                                                            onClick={() =>
                                                                handleDelete(
                                                                    data.id
                                                                )
                                                            }
                                                        >
                                                            Hapus
                                                        </DangerButton>
                                                    </td>
                                                </tr>
                                            );
                                        }
                                    )}

                                    {props.aset_pemeliharaan.data.length ==
                                        0 && (
                                        <tr>
                                            <td
                                                colSpan={4}
                                                className="text-center"
                                            >
                                                Data Belum Ada
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>

                            <Pagination
                                totals={props.aset_pemeliharaan.total}
                                className="mt-2"
                                links={props.aset_pemeliharaan.links}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default Index;
