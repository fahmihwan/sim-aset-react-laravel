import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/inertia-react";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import InputError from "@/Components/InputError";
import SecondaryButton from "@/Components/SecondaryButton";
import PrimaryButton from "@/Components/PrimaryButton";

export default function Create(props) {
    const { data, setData, post, processing, errors, reset } = useForm({
        ruangan_id: "",
    });

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post("/setting/gudang");
        // Inertia.post("/ruangan", data);
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Tambah Aset
                </h2>
            }
        >
            <Head title="Tambah Ruangan " />
            <div className="pt-5 px-8 flex justify-end">
                <Link
                    href={route("aset.index")}
                    className="btn btn-sm bg-neutral "
                >
                    Kembali
                </Link>
            </div>

            <div className="py-5">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white w-1/2  overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-5">
                            <h1 className="text-2xl mb-3">Form aset</h1>
                            <form onSubmit={handleSubmit}>

                                <div className="mb-3">
                                    <InputLabel
                                        forInput="kategori_id"
                                        value="kategori"
                                    />

                                    <select
                                        id="kategori"
                                        defaultValue={"DEFAULT"}
                                        name="ruangan_id"
                                        className="border-gray-300 w-full   focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        onChange={onHandleChange}
                                    >
                                        <option value={"DEFAULT"} disabled>
                                            Pilih Kategori
                                        </option>
                                        {props.ruangans?.map((data, i) => {
                                            return (
                                                <option key={i} value={data.id}>
                                                    {data.ruangan}
                                                </option>
                                            );
                                        })}
                                    </select>


                                </div>

                                <SecondaryButton
                                    className="mr-3"
                                    onClick={() => reset()}
                                >
                                    Reset
                                </SecondaryButton>
                                <PrimaryButton type="submit">
                                    Submit
                                </PrimaryButton>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
