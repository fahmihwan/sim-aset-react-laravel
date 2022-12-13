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
        kode: props.kode || "",
        keterangan: "",
        tanggal_masuk: "",
    });

    const onHandleChange = (e) => {
        setData(e.target.name, e.target.value);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post("/aset_masuk");
    };

    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={
                <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                    Tambah Aset Masuk
                </h2>
            }
        >
            <Head title="Tambah Ruangan " />
            <div className="pt-5 px-8 flex justify-end">
                <Link
                    href={route("aset_masuk.index")}
                    className="btn btn-sm bg-neutral "
                >
                    Kembali
                </Link>
            </div>

            <div className="py-5">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white w-1/2  overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-5">
                            <h1 className="text-2xl mb-3">Form Aset Masuk</h1>
                            <form onSubmit={handleSubmit}>
                                <div className="mb-3">
                                    <InputLabel forInput="kode" value="kode" />
                                    <TextInput
                                        id="kode"
                                        type="text"
                                        name="kode"
                                        readonly={true}
                                        value={data.kode}
                                        handleChange={onHandleChange}
                                        className="mt-1 block w-full bg-gray-100"
                                        isFocused={true}
                                    />
                                    <InputError
                                        message={props.errors.kode}
                                        className="mt-2"
                                    />
                                </div>
                                <div className="mb-3">
                                    <InputLabel
                                        forInput="tanggal_masuk"
                                        value="Tanggal aset masuk"
                                    />
                                    <TextInput
                                        id="tanggal_masuk"
                                        type="date"
                                        name="tanggal_masuk"
                                        value={data.tanggal_masuk}
                                        handleChange={onHandleChange}
                                        className="mt-1 block w-full"
                                        isFocused={true}
                                    />
                                    <InputError
                                        message={props.errors.tanggal_masuk}
                                        className="mt-2"
                                    />
                                </div>
                                <div className="mb-3">
                                    <InputLabel
                                        forInput="keterangan"
                                        value="keterangan"
                                    />
                                    <TextInput
                                        id="keterangan"
                                        type="text"
                                        name="keterangan"
                                        value={data.keterangan}
                                        handleChange={onHandleChange}
                                        className="mt-1 block w-full"
                                        isFocused={true}
                                    />
                                    <InputError
                                        message={props.errors.keterangan}
                                        className="mt-2"
                                    />
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
