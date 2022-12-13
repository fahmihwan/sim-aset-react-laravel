import DangerButton from "@/Components/DangerButton";
import Pagination from "@/Components/Pagination";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage } from "@inertiajs/inertia-react";
import { Link } from "@inertiajs/inertia-react";

const Index = (props) => {
    const { errors } = usePage().props;

    const handleDelete = (id) => {
        confirm("apakah anda yakin ingin menghapus?") &&
            Inertia.delete(`/aset/${id}`);
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    aset
                </h2>
            }
        >
            <Head title="Ruangan" />

            <div className="pt-5 px-8  flex justify-end">
                <Link
                    href={route("aset.create")}
                    className="btn btn-sm bg-neutral "
                >
                    Tambah Data
                </Link>
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
                                            aset
                                        </th>
                                        <th className="bg-neutral text-white">
                                            kategori
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Created At
                                        </th>
                                        <th className="bg-neutral text-white">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {props.asets.data.map((data, i) => {
                                        return (
                                            <tr key={i}>
                                                <th>{i + props.asets.from}</th>
                                                <td>{data.nama}</td>
                                                <td>
                                                    {data.kategori.kategori}
                                                </td>
                                                <td>{data.created_at}</td>
                                                <td>
                                                    <Link
                                                        href={`/aset/${data.id}/edit`}
                                                        className="btn btn-sm btn-warning mr-3 "
                                                    >
                                                        Edit
                                                    </Link>
                                                    {/* <Link className="btn btn-sm btn-error ">
                                                        Hapus
                                                    </Link> */}
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
                                    })}

                                    {props.asets.data.length == 0 && (
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
                                totals={props.asets.total}
                                className="mt-2"
                                links={props.asets.links}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
};

export default Index;
